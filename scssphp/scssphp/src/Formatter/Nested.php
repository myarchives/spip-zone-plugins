<?php
/**
 * SCSSPHP
 *
 * @copyright 2012-2015 Leaf Corcoran
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://leafo.github.io/scssphp
 */

namespace Leafo\ScssPhp\Formatter;

use Leafo\ScssPhp\Formatter;

/**
 * SCSS nested formatter
 *
 * @author Leaf Corcoran <leafot@gmail.com>
 */
class Nested extends Formatter
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->indentLevel = 0;
        $this->indentChar = '  ';
        $this->break = "\n";
        $this->open = ' {';
        $this->close = ' }';
        $this->tagSeparator = ', ';
        $this->assignSeparator = ': ';
    }

    /**
     * Adjust the depths of all children, depth first
     *
     * @param \stdClass $block
     */
    public function adjustAllChildren($block)
    {
        // flatten empty nested blocks
        $children = array();
        foreach ($block->children as $i => $child) {
            if (empty($child->lines) && empty($child->children)) {
                if (isset($block->children[$i + 1])) {
                    $block->children[$i + 1]->depth = $child->depth;
                }
                continue;
            }
            $children[] = $child;
        }

        $count = count($children);
        for ($i = 0; $i < $count; $i++) {
            $depth = $children[$i]->depth;
            $j = $i + 1;
            if (isset($children[$j]) && $depth < $children[$j]->depth) {
                $childDepth = $children[$j]->depth;
                for (; $j < $count; $j++) {
                    if ($depth < $children[$j]->depth && $childDepth >= $children[$j]->depth) {
                        $children[$j]->depth = $depth + 1;
                    }
                }
            }
        }

        $block->children = $children;

        // make relative to parent
        foreach ($block->children as $child) {
            $this->adjustAllChildren($child);
            $child->depth = $child->depth - $block->depth;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function blockLines($inner, $block)
    {
        $glue = $this->break . $inner;

        foreach ($block->lines as $index => $line) {
            if (substr($line, 0, 2) === '/*') {
                $block->lines[$index] = preg_replace('/(\r|\n)+/', $glue, $line);
            }
        }

        echo $inner . implode($glue, $block->lines);

        if (! empty($block->children)) {
            echo $this->break;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function block($block)
    {
        if ($block->type == 'root') {
            $this->adjustAllChildren($block);
        }

        $inner = $pre = $this->indentStr($block->depth - 1);
        if (! empty($block->selectors)) {
            echo $pre .
                implode($this->tagSeparator, $block->selectors) .
                $this->open . $this->break;
            $this->indentLevel++;
            $inner = $this->indentStr($block->depth - 1);
        }

        if (! empty($block->lines)) {
            $this->blockLines($inner, $block);
        }

        foreach ($block->children as $i => $child) {
            $this->block($child);

            if ($i < count($block->children) - 1) {
                echo $this->break;

                if (isset($block->children[$i + 1])) {
                    $next = $block->children[$i + 1];
                    if ($next->depth == max($block->depth, 1) && $child->depth >= $next->depth) {
                        echo $this->break;
                    }
                }
            }
        }

        if (! empty($block->selectors)) {
            $this->indentLevel--;
            echo $this->close;
        }

        if ($block->type == 'root') {
            echo $this->break;
        }
    }
}
