<?php

namespace Cerdic\Geometrize\Rasterizer;

class Rasterizer {
	public function __construct(){
	}

	static function drawLines($image, $c, $lines){

		// easy case: opacity=1, just a copy of the color $c, much faster
		if ($c & 255===255){
			foreach ($lines as &$line) {
				$_g1 = $line['x2']+1;
				$y = $line['y'];
				for ($x = $line['x1']; $x<$_g1; $x++){
					$image->data[$y][$x] = $c;
					if (isset($image->errorCache[$y][$x])){
						unset($image->errorCache[$y][$x]);
					}
				}
			}
		} else {
			$sr = $c >> 24 & 255;
			$sr = $sr | $sr << 8;
			$sr = $sr*($c & 255);
			$sr = intval($sr/255);
			$sg = $c >> 16 & 255;
			$sg = $sg | $sg << 8;
			$sg = $sg*($c & 255);
			$sg = intval($sg/255);
			$sb = $c >> 8 & 255;
			$sb = $sb | $sb << 8;
			$sb = $sb*($c & 255);
			$sb = intval($sb/255);
			$sa = $c & 255;
			$sa = $sa | $sa << 8;

			foreach ($lines as &$line) {
				$y = $line['y'];
				$ma = 65535;
				$m = 65535;
				$as = ($m-$sa*($ma/$m))*257;
				$a = intval($as);

				$_g2 = $line['x1'];
				$_g1 = $line['x2']+1;
				while ($_g2<$_g1){
					$_g2 = $_g2+1;
					$x = $_g2-1;
					$d = $image->data[$y][$x];
					$dr = $d >> 24 & 255;
					$dg = $d >> 16 & 255;
					$db = $d >> 8 & 255;
					$da = $d & 255;
					$int = $dr*$a+$sr*$ma;
					$r = null;
					if ($int<0){
						$r = 4294967296.0+$int;
					} else {
						$r = $int+0.0;
					}
					$int1 = $m;
					$r1 = null;
					if ($int1<0){
						$r1 = 4294967296.0+$int1;
					} else {
						$r1 = $int1+0.0;
					}
					$r2 = intval($r/$r1) >> 8;
					$int2 = $dg*$a+$sg*$ma;
					$g = null;
					if ($int2<0){
						$g = 4294967296.0+$int2;
					} else {
						$g = $int2+0.0;
					}
					$int3 = $m;
					$g1 = null;
					if ($int3<0){
						$g1 = 4294967296.0+$int3;
					} else {
						$g1 = $int3+0.0;
					}
					$g2 = intval($g/$g1) >> 8;
					$int4 = $db*$a+$sb*$ma;
					$b = null;
					if ($int4<0){
						$b = 4294967296.0+$int4;
					} else {
						$b = $int4+0.0;
					}
					$int5 = $m;
					$b1 = null;
					if ($int5<0){
						$b1 = 4294967296.0+$int5;
					} else {
						$b1 = $int5+0.0;
					}
					$b2 = intval($b/$b1) >> 8;
					$int6 = $da*$a+$sa*$ma;
					$a1 = null;
					if ($int6<0){
						$a1 = 4294967296.0+$int6;
					} else {
						$a1 = $int6+0.0;
					}
					$int7 = $m;
					$a2 = null;
					if ($int7<0){
						$a2 = 4294967296.0+$int7;
					} else {
						$a2 = $int7+0.0;
					}
					$a3 = intval($a1/$a2) >> 8;
					{
						if (!true){
							throw new \Exception("FAIL: min <= max");
						}
						$color = null;
						if ($r2<0){
							$color = 0;
						} else {
							if ($r2>255){
								$color = 255;
							} else {
								$color = $r2;
							}
						}
						if (!true){
							throw new \Exception("FAIL: min <= max");
						}
						$color1 = null;
						if ($g2<0){
							$color1 = 0;
						} else {
							if ($g2>255){
								$color1 = 255;
							} else {
								$color1 = $g2;
							}
						}
						if (!true){
							throw new \Exception("FAIL: min <= max");
						}
						$color2 = null;
						if ($b2<0){
							$color2 = 0;
						} else {
							if ($b2>255){
								$color2 = 255;
							} else {
								$color2 = $b2;
							}
						}
						if (!true){
							throw new \Exception("FAIL: min <= max");
						}
						$color3 = null;
						if ($a3<0){
							$color3 = 0;
						} else {
							if ($a3>255){
								$color3 = 255;
							} else {
								$color3 = $a3;
							}
						}
						$image->data[$y][$x] = ($color << 24)+($color1 << 16)+($color2 << 8)+$color3;
						if (isset($image->errorCache[$y][$x])){
							unset($image->errorCache[$y][$x]);
						}
					}
				}
			}
		}
	}

	static function copyLines($destination, $source, $lines){
		if (!($destination!==null)){
			throw new \Exception("FAIL: destination != null");
		}
		if (!($source!==null)){
			throw new \Exception("FAIL: source != null");
		}
		if (!($lines!==null)){
			throw new \Exception("FAIL: lines != null");
		}

		foreach ($lines as &$line) {
			$y = $line['y'];
			$_g1 = $line['x2']+1;
			for ($x = $line['x1']; $x<$_g1; $x++){
				$destination->data[$y][$x] = $source->data[$y][$x];
			}
		}
	}

	/**
	 * @param int $x1
	 * @param int $y1
	 * @param int $x2
	 * @param int $y2
	 * @param &array
	 * @return array
	 */
	static function bresenham($x1, $y1, $x2, $y2, &$points){
		$dx = $x2-$x1;
		$ix1 = ($dx>0 ? 1 : 0);
		$ix2 = ($dx<0 ? 1 : 0);
		$ix = $ix1-$ix2;

		if ($dx<0){
			$dx *= -1;
		}
		$dx = $dx << 1;

		$dy = $y2-$y1;
		$iy1 = ($dy>0 ? 1 : 0);
		$iy2 = ($dy<0 ? 1 : 0);
		$iy = $iy1-$iy2;

		if ($dy<0){
			$dy *= -1;
		}
		$dy = $dy << 1;


		if (!isset($points[$y1])) {
			$points[$y1] = [];
		}
		$points[$y1][] = $x1;
		if ($dx>=$dy){
			$error = $dy-($dx >> 1);
			while ($x1!==$x2){
				if ($error>0 or ($error===0 and $ix>0)){
					$error -= $dx;
					$y1 += $iy;
					if (!isset($points[$y1])) {
						$points[$y1] = [];
					}
				}
				$error += $dy;
				$x1 += $ix;
				$points[$y1][] = $x1;
			}
		} else {
			$error = $dx-($dy >> 1);
			while ($y1!==$y2){
				if ($error>0 or ($error===0 and $iy>0)){
					$error -= $dy;
					$x1 += $ix;
				}
				$error += $dx;
				$y1 += $iy;
				if (!isset($points[$y1])) {
					$points[$y1] = [];
				}
				$points[$y1][] = $x1;
			}
		}
		return $points;
	}

	/**
	 * @param array $points
	 * @param int $xBound
	 * @param int $yBound
	 * @return array
	 */
	static function scanlinesForPolygon($points, $xBound, $yBound){
		return Rasterizer::scanlinesForPath($points, $xBound, $yBound, true);
	}

	/**
	 * @param array $points
	 * @param int $xBound
	 * @param int $yBound
	 * @param bool $isClosed
	 * @return array
	 */
	static function scanlinesForPath($points, $xBound, $yBound, $isClosed = false){
		$lines = [];

		if ($isClosed) {
			$prevPoint = end($points);
		}
		else {
			$prevPoint = array_shift($points);
		}

		$YXpoints = [];

		foreach ($points as $point) {
			Rasterizer::bresenham($prevPoint['x'], $prevPoint['y'], $point['x'], $point['y'], $YXpoints);
			$prevPoint = $point;
		}

		// not super useful
		// ksort($YXpoints);

		foreach ($YXpoints as $y => $xs){
			if ($y>=0 and $y<$yBound){
				$minx = min($xs);
				$maxx = max($xs);
				if ($minx<$xBound and $maxx>=0){
					$lines[] = ['y' => $y, 'x1'=>max($minx, 0), 'x2' =>min($maxx, $xBound-1)];
				}
			}
		}

		return $lines;
	}

}
