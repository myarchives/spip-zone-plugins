<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * @package	isemail
 * @author	Dominic Sayers <dominic_sayers@hotmail.com>
 * @copyright	2009 Dominic Sayers
 * @license	http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link	http://www.dominicsayers.com/isemail
 * @version	1.16 - Added optional diagnosis codes (amended all lines with a return statement)
 */

/*
Copyright (c) 2008-2010, Dominic Sayers
All rights reserved.

Redistribution and use in source and binary forms, with or without modification,
are permitted provided that the following conditions are met:

 * Redistributions of source code must retain the above copyright notice, this
   list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice,
   this list of conditions and the following disclaimer in the documentation
   and/or other materials provided with the distribution.
 * Neither the name of Dominic Sayers nor the names of its contributors may be
   used to endorse or promote products derived from this software without
   specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

/*.
	require_module 'standard';
	require_module 'pcre';
.*/
/*.mixed.*/ function is_email (/*.string.*/ $email, $checkDNS = false, $diagnose = false) {
	// Check that $email is a valid address. Read the following RFCs to understand the constraints:
	// 	(http://tools.ietf.org/html/rfc5322)
	// 	(http://tools.ietf.org/html/rfc3696)
	// 	(http://tools.ietf.org/html/rfc5321)
	// 	(http://tools.ietf.org/html/rfc4291#section-2.2)
	// 	(http://tools.ietf.org/html/rfc1123#section-2.1)

	if (!defined('ISEMAIL_VALID')) {
		define('ISEMAIL_VALID'			, 0);
		define('ISEMAIL_TOOLONG'		, 1);
		define('ISEMAIL_NOAT'			, 2);
		define('ISEMAIL_NOLOCALPART'		, 3);
		define('ISEMAIL_NODOMAIN'		, 4);
		define('ISEMAIL_ZEROLENGTHELEMENT'	, 5);
		define('ISEMAIL_BADCOMMENT_START'	, 6);
		define('ISEMAIL_BADCOMMENT_END'		, 7);
		define('ISEMAIL_UNESCAPEDDELIM'		, 8);
		define('ISEMAIL_EMPTYELEMENT'		, 9);
		define('ISEMAIL_UNESCAPEDSPECIAL'	, 10);
		define('ISEMAIL_LOCALTOOLONG'		, 11);
		define('ISEMAIL_IPV4BADPREFIX'		, 12);
		define('ISEMAIL_IPV6BADPREFIXMIXED'	, 13);
		define('ISEMAIL_IPV6BADPREFIX'		, 14);
		define('ISEMAIL_IPV6GROUPCOUNT'		, 15);
		define('ISEMAIL_IPV6DOUBLEDOUBLECOLON'	, 16);
		define('ISEMAIL_IPV6BADCHAR'		, 17);
		define('ISEMAIL_IPV6TOOMANYGROUPS'	, 18);
		define('ISEMAIL_TLD'			, 19);
		define('ISEMAIL_DOMAINEMPTYELEMENT'	, 20);
		define('ISEMAIL_DOMAINELEMENTTOOLONG'	, 21);
		define('ISEMAIL_DOMAINBADCHAR'		, 22);
		define('ISEMAIL_DOMAINTOOLONG'		, 23);
		define('ISEMAIL_TLDNUMERIC'		, 24);
		define('ISEMAIL_DOMAINNOTFOUND'		, 25);
		define('ISEMAIL_NOTDEFINED'		, 99);
	}

	// the upper limit on address lengths should normally be considered to be 256
	// 	(http://www.rfc-editor.org/errata_search.php?rfc=3696)
	// 	NB I think John Klensin is misreading RFC 5321 and the the limit should actually be 254
	// 	However, I will stick to the published number until it is changed.
	//
	// The maximum total length of a reverse-path or forward-path is 256
	// characters (including the punctuation and element separators)
	// 	(http://tools.ietf.org/html/rfc5321#section-4.5.3.1.3)
	$emailLength = strlen($email);
	if ($emailLength > 256)			return $diagnose ? ISEMAIL_TOOLONG	: false;	// Too long

	// Contemporary email addresses consist of a "local part" separated from
	// a "domain part" (a fully-qualified domain name) by an at-sign ("@").
	// 	(http://tools.ietf.org/html/rfc3696#section-3)
	$atIndex = strrpos($email,'@');

	if ($atIndex === false)			return $diagnose ? ISEMAIL_NOAT		: false;	// No at-sign
	if ($atIndex === 0)			return $diagnose ? ISEMAIL_NOLOCALPART	: false;	// No local part
	if ($atIndex === $emailLength - 1)	return $diagnose ? ISEMAIL_NODOMAIN	: false;	// No domain part
// revision 1.14: Length test bug suggested by Andrew Campbell of Gloucester, MA
	
	// Sanitize comments
	// - remove nested comments, quotes and dots in comments
	// - remove parentheses and dots from quoted strings
	$braceDepth	= 0;
	$inQuote	= false;
	$escapeThisChar	= false;

	for ($i = 0; $i < $emailLength; ++$i) {
		$char = $email[$i];
		$replaceChar = false;

		if ($char === '\\') {
			$escapeThisChar = !$escapeThisChar;	// Escape the next character?
		} else {
			switch ($char) {
			case '(':
				if ($escapeThisChar) {
					$replaceChar = true;
				} else {
					if ($inQuote) {
						$replaceChar = true;
					} else {
						if ($braceDepth++ > 0) $replaceChar = true;	// Increment brace depth
					}
				}

				break;
			case ')':
				if ($escapeThisChar) {
					$replaceChar = true;
				} else {
					if ($inQuote) {
						$replaceChar = true;
					} else {
						if (--$braceDepth > 0) $replaceChar = true;	// Decrement brace depth
						if ($braceDepth < 0) $braceDepth = 0;
					}
				}

				break;
			case '"':
				if ($escapeThisChar) {
					$replaceChar = true;
				} else {
					if ($braceDepth === 0) {
						$inQuote = !$inQuote;	// Are we inside a quoted string?
					} else {
						$replaceChar = true;
					}
				}

				break;
			case '.':	// Dots don't help us either
				if ($escapeThisChar) {
					$replaceChar = true;
				} else {
					if ($braceDepth > 0) $replaceChar = true;
				}

				break;
			default:
			}

			$escapeThisChar = false;
//			if ($replaceChar) $email[$i] = 'x';	// Replace the offending character with something harmless
// revision 1.12: Line above replaced because PHPLint doesn't like that syntax
			if ($replaceChar) $email = (string) substr_replace($email, 'x', $i, 1);	// Replace the offending character with something harmless
		}
	}

	$localPart	= substr($email, 0, $atIndex);
	$domain		= substr($email, $atIndex + 1);
	$FWS		= "(?:(?:(?:[ \\t]*(?:\\r\\n))?[ \\t]+)|(?:[ \\t]+(?:(?:\\r\\n)[ \\t]+)*))";	// Folding white space
	// Let's check the local part for RFC compliance...
	//
	// local-part      =       dot-atom / quoted-string / obs-local-part
	// obs-local-part  =       word *("." word)
	// 	(http://tools.ietf.org/html/rfc5322#section-3.4.1)
	//
	// Problem: need to distinguish between "first.last" and "first"."last"
	// (i.e. one element or two). And I suck at regexes.
	$dotArray	= /*. (array[int]string) .*/ preg_split('/\\.(?=(?:[^\\"]*\\"[^\\"]*\\")*(?![^\\"]*\\"))/m', $localPart);
	$partLength	= 0;

	foreach ($dotArray as $element) {
		// Remove any leading or trailing FWS
		$element	= preg_replace("/^$FWS|$FWS\$/", '', $element);
		$elementLength	= strlen($element);

		if ($elementLength === 0)								return $diagnose ? ISEMAIL_ZEROLENGTHELEMENT	: false;	// Can't have empty element (consecutive dots or dots at the start or end)
// revision 1.15: Speed up the test and get rid of "unitialized string offset" notices from PHP

		// We need to remove any valid comments (i.e. those at the start or end of the element)
		if ($element[0] === '(') {
			$indexBrace = strpos($element, ')');
			if ($indexBrace !== false) {
				if (preg_match('/(?<!\\\\)[\\(\\)]/', substr($element, 1, $indexBrace - 1)) > 0) {
													return $diagnose ? ISEMAIL_BADCOMMENT_START	: false;	// Illegal characters in comment
				}
				$element	= substr($element, $indexBrace + 1, $elementLength - $indexBrace - 1);
				$elementLength	= strlen($element);
			}
		}
		
		if ($element[$elementLength - 1] === ')') {
			$indexBrace = strrpos($element, '(');
			if ($indexBrace !== false) {
				if (preg_match('/(?<!\\\\)(?:[\\(\\)])/', substr($element, $indexBrace + 1, $elementLength - $indexBrace - 2)) > 0) {
													return $diagnose ? ISEMAIL_BADCOMMENT_END	: false;	// Illegal characters in comment
				}
				$element	= substr($element, 0, $indexBrace);
				$elementLength	= strlen($element);
			}
		}

		// Remove any leading or trailing FWS around the element (inside any comments)
		$element = preg_replace("/^$FWS|$FWS\$/", '', $element);

		// What's left counts towards the maximum length for this part
		if ($partLength > 0) $partLength++;	// for the dot
		$partLength += strlen($element);

		// Each dot-delimited component can be an atom or a quoted string
		// (because of the obs-local-part provision)
		if (preg_match('/^"(?:.)*"$/s', $element) > 0) {
			// Quoted-string tests:
			//
			// Remove any FWS
			$element = preg_replace("/(?<!\\\\)$FWS/", '', $element);
			// My regex skillz aren't up to distinguishing between \" \\" \\\" \\\\" etc.
			// So remove all \\ from the string first...
			$element = preg_replace('/\\\\\\\\/', ' ', $element);
			if (preg_match('/(?<!\\\\|^)["\\r\\n\\x00](?!$)|\\\\"$|""/', $element) > 0)	return $diagnose ? ISEMAIL_UNESCAPEDDELIM	: false;	// ", CR, LF and NUL must be escaped, "" is too short
		} else {
			// Unquoted string tests:
			//
			// Period (".") may...appear, but may not be used to start or end the
			// local part, nor may two or more consecutive periods appear.
			// 	(http://tools.ietf.org/html/rfc3696#section-3)
			//
			// A zero-length element implies a period at the beginning or end of the
			// local part, or two periods together. Either way it's not allowed.
			if ($element === '')								return $diagnose ? ISEMAIL_EMPTYELEMENT	: false;	// Dots in wrong place

			// Any ASCII graphic (printing) character other than the
			// at-sign ("@"), backslash, double quote, comma, or square brackets may
			// appear without quoting.  If any of that list of excluded characters
			// are to appear, they must be quoted
			// 	(http://tools.ietf.org/html/rfc3696#section-3)
			//
			// Any excluded characters? i.e. 0x00-0x20, (, ), <, >, [, ], :, ;, @, \, comma, period, "
			if (preg_match('/[\\x00-\\x20\\(\\)<>\\[\\]:;@\\\\,\\."]/', $element) > 0)	return $diagnose ? ISEMAIL_UNESCAPEDSPECIAL	: false;	// These characters must be in a quoted string
		}
	}

	if ($partLength > 64) return $diagnose ? ISEMAIL_LOCALTOOLONG	: false;	// Local part must be 64 characters or less

	// Now let's check the domain part...

	// The domain name can also be replaced by an IP address in square brackets
	// 	(http://tools.ietf.org/html/rfc3696#section-3)
	// 	(http://tools.ietf.org/html/rfc5321#section-4.1.3)
	// 	(http://tools.ietf.org/html/rfc4291#section-2.2)
	if (preg_match('/^\\[(.)+]$/', $domain) === 1) {
		// It's an address-literal
		$addressLiteral = substr($domain, 1, strlen($domain) - 2);
		$matchesIP	= array();
		
		// Extract IPv4 part from the end of the address-literal (if there is one)
		if (preg_match('/\\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/', $addressLiteral, $matchesIP) > 0) {
			$index = strrpos($addressLiteral, $matchesIP[0]);
			
			if ($index === 0) {
				// Nothing there except a valid IPv4 address, so...
				return $diagnose ? ISEMAIL_VALID : true;
			} else {
				// Assume it's an attempt at a mixed address (IPv6 + IPv4)
				if ($addressLiteral[$index - 1] !== ':')	return $diagnose ? ISEMAIL_IPV4BADPREFIX	: false;	// Character preceding IPv4 address must be ':'
				if (substr($addressLiteral, 0, 5) !== 'IPv6:')	return $diagnose ? ISEMAIL_IPV6BADPREFIXMIXED	: false;	// RFC5321 section 4.1.3

				$IPv6		= substr($addressLiteral, 5, ($index ===7) ? 2 : $index - 6);
				$groupMax	= 6;
			}
		} else {
			// It must be an attempt at pure IPv6
			if (substr($addressLiteral, 0, 5) !== 'IPv6:')		return $diagnose ? ISEMAIL_IPV6BADPREFIX	: false;	// RFC5321 section 4.1.3
			$IPv6 = substr($addressLiteral, 5);
			$groupMax = 8;
		}

		$groupCount	= preg_match_all('/^[0-9a-fA-F]{0,4}|\\:[0-9a-fA-F]{0,4}|(.)/', $IPv6, $matchesIP);
		$index		= strpos($IPv6,'::');

		if ($index === false) {
			// We need exactly the right number of groups
			if ($groupCount !== $groupMax)				return $diagnose ? ISEMAIL_IPV6GROUPCOUNT	: false;	// RFC5321 section 4.1.3
		} else {
			if ($index !== strrpos($IPv6,'::'))			return $diagnose ? ISEMAIL_IPV6DOUBLEDOUBLECOLON : false;	// More than one '::'
			$groupMax = ($index === 0 || $index === (strlen($IPv6) - 2)) ? $groupMax : $groupMax - 1;
			if ($groupCount > $groupMax)				return $diagnose ? ISEMAIL_IPV6TOOMANYGROUPS	: false;	// Too many IPv6 groups in address
		}

		// Check for unmatched characters
		array_multisort($matchesIP[1], SORT_DESC);
		if ($matchesIP[1][0] !== '')					return $diagnose ? ISEMAIL_IPV6BADCHAR		: false;	// Illegal characters in address

		// It's a valid IPv6 address, so...
		return $diagnose ? ISEMAIL_VALID : true;
	} else {
		// It's a domain name...

		// The syntax of a legal Internet host name was specified in RFC-952
		// One aspect of host name syntax is hereby changed: the
		// restriction on the first character is relaxed to allow either a
		// letter or a digit.
		// 	(http://tools.ietf.org/html/rfc1123#section-2.1)
		//
		// NB RFC 1123 updates RFC 1035, but this is not currently apparent from reading RFC 1035.
		//
		// Most common applications, including email and the Web, will generally not
		// permit...escaped strings
		// 	(http://tools.ietf.org/html/rfc3696#section-2)
		//
		// the better strategy has now become to make the "at least one period" test,
		// to verify LDH conformance (including verification that the apparent TLD name
		// is not all-numeric)
		// 	(http://tools.ietf.org/html/rfc3696#section-2)
		//
		// Characters outside the set of alphabetic characters, digits, and hyphen MUST NOT appear in domain name
		// labels for SMTP clients or servers
		// 	(http://tools.ietf.org/html/rfc5321#section-4.1.2)
		//
		// RFC5321 precludes the use of a trailing dot in a domain name for SMTP purposes
		// 	(http://tools.ietf.org/html/rfc5321#section-4.1.2)
		$dotArray	= /*. (array[int]string) .*/ preg_split('/\\.(?=(?:[^\\"]*\\"[^\\"]*\\")*(?![^\\"]*\\"))/m', $domain);
		$partLength	= 0;
		$element	= ''; // Since we use $element after the foreach loop let's make sure it has a value
// revision 1.13: Line above added because PHPLint now checks for Definitely Assigned Variables

		if (count($dotArray) === 1)					return $diagnose ? ISEMAIL_TLD	: false;	// Mail host can't be a TLD (cite? What about localhost?)

		foreach ($dotArray as $element) {
			// Remove any leading or trailing FWS
			$element	= preg_replace("/^$FWS|$FWS\$/", '', $element);
			$elementLength	= strlen($element);
	
			// Each dot-delimited component must be of type atext
			// A zero-length element implies a period at the beginning or end of the
			// local part, or two periods together. Either way it's not allowed.
			if ($elementLength === 0)				return $diagnose ? ISEMAIL_DOMAINEMPTYELEMENT	: false;	// Dots in wrong place
// revision 1.15: Speed up the test and get rid of "unitialized string offset" notices from PHP
	
			// Then we need to remove all valid comments (i.e. those at the start or end of the element
			if ($element[0] === '(') {
				$indexBrace = strpos($element, ')');
				if ($indexBrace !== false) {
					if (preg_match('/(?<!\\\\)[\\(\\)]/', substr($element, 1, $indexBrace - 1)) > 0) {
										return $diagnose ? ISEMAIL_BADCOMMENTSTART	: false;	// Illegal characters in comment
					}
					$element	= substr($element, $indexBrace + 1, $elementLength - $indexBrace - 1);
					$elementLength	= strlen($element);
				}
			}
			
			if ($element[$elementLength - 1] === ')') {
				$indexBrace = strrpos($element, '(');
				if ($indexBrace !== false) {
					if (preg_match('/(?<!\\\\)(?:[\\(\\)])/', substr($element, $indexBrace + 1, $elementLength - $indexBrace - 2)) > 0)
										return $diagnose ? ISEMAIL_BADCOMMENTEND	: false;	// Illegal characters in comment

					$element	= substr($element, 0, $indexBrace);
					$elementLength	= strlen($element);
				}
			}			
	
			// Remove any leading or trailing FWS around the element (inside any comments)
			$element = preg_replace("/^$FWS|$FWS\$/", '', $element);
	
			// What's left counts towards the maximum length for this part
			if ($partLength > 0) $partLength++;	// for the dot
			$partLength += strlen($element);
	
			// The DNS defines domain name syntax very generally -- a
			// string of labels each containing up to 63 8-bit octets,
			// separated by dots, and with a maximum total of 255
			// octets.
			// 	(http://tools.ietf.org/html/rfc1123#section-6.1.3.5)
			if ($elementLength > 63)				return $diagnose ? ISEMAIL_DOMAINELEMENTTOOLONG	: false;	// Label must be 63 characters or less
	
			// Any ASCII graphic (printing) character other than the
			// at-sign ("@"), backslash, double quote, comma, or square brackets may
			// appear without quoting.  If any of that list of excluded characters
			// are to appear, they must be quoted
			// 	(http://tools.ietf.org/html/rfc3696#section-3)
			//
			// If the hyphen is used, it is not permitted to appear at
			// either the beginning or end of a label.
			// 	(http://tools.ietf.org/html/rfc3696#section-2)
			//
			// Any excluded characters? i.e. 0x00-0x20, (, ), <, >, [, ], :, ;, @, \, comma, period, "
			if (preg_match('/[\\x00-\\x20\\(\\)<>\\[\\]:;@\\\\,\\."]|^-|-$/', $element) > 0) {
										return $diagnose ? ISEMAIL_DOMAINBADCHAR	: false;
			}
		}

		if ($partLength > 255) 						return $diagnose ? ISEMAIL_DOMAINTOOLONG	: false;	// Domain part must be 255 characters or less (http://tools.ietf.org/html/rfc1123#section-6.1.3.5)

		if (preg_match('/^[0-9]+$/', $element) > 0)			return $diagnose ? ISEMAIL_TLDNUMERIC		: false;	// TLD can't be all-numeric (http://www.apps.ietf.org/rfc/rfc3696.html#sec-2)

		// Check DNS?
		if ($checkDNS && function_exists('checkdnsrr')) {
			if (!(checkdnsrr($domain, 'A') || checkdnsrr($domain, 'MX'))) {
										return $diagnose ? ISEMAIL_DOMAINNOTFOUND	: false;	// Domain doesn't actually exist
			}
		}
	}

	// Eliminate all other factors, and the one which remains must be the truth.
	// 	(Sherlock Holmes, The Sign of Four)
	return $diagnose ? ISEMAIL_VALID : true;
}
?>
