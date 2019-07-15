<?php

// Generated by Haxe 3.4.7
class geometrize_shape_QuadraticBezier implements geometrize_shape_Shape {

	/**
	 * @var int
	 */
	protected $cx;

	/**
	 * @var int
	 */
	protected $cy;

	/**
	 * @var int
	 */
	protected $x1;

	/**
	 * @var int
	 */
	protected $y1;

	/**
	 * @var int
	 */
	protected $x2;

	/**
	 * @var int
	 */
	protected $y2;

	/**
	 * @var int
	 */
	protected $xBound;

	/**
	 * @var int
	 */
	protected $yBound;

	/**
	 * @var int
	 */
	public $color;

	/**
	 * Rasterized lines
	 * @var null|array
	 */
	protected $lines = null;

	public function __construct($xBound, $yBound, $sizeFactor=1.0){
		$this->x1 = mt_rand(0, $xBound-1);
		$this->y1 = mt_rand(0, $yBound-1);

		$this->x2 = mt_rand(0, $xBound-1);
		$this->y2 = mt_rand(0, $yBound-1);

		$this->cx = mt_rand(0, $xBound-1);
		$this->cy = mt_rand(0, $yBound-1);

		$this->xBound = $xBound;
		$this->yBound = $yBound;
	}

	public function rasterize(){
		if (!$this->lines){
			$points = [];
			$pointCount = 20;

			for ($i=0;$i<=$pointCount;$i++) {
				$t = $i/$pointCount;
				$tp = 1-$t;
				$x = intval(round($tp*($tp*$this->x1+$t*$this->cx)+$t*($tp*$this->cx+$t*$this->x2)));
				$y = intval(round($tp*($tp*$this->y1+$t*$this->cy)+$t*($tp*$this->cy+$t*$this->y2)));
				$points[] = ["x" => $x, "y" => $y];
			}

			$prevPoint = array_shift($points);
			$this->lines = [];
			foreach ($points as $point){
				$this->lines = array_merge($this->lines, geometrize_rasterizer_Rasterizer::scanlinesForPath([$prevPoint, $point], $this->xBound, $this->yBound));
				$prevPoint = $point;
			}
		}

		return $this->lines;
	}

	/**
	 * Mutate the shape
	 */
	public function mutate(){
		$r = mt_rand(0, 2);
		switch ($r) {
			case 0:
				$this->cx += mt_rand(-8, +8);
				$this->cx = max(min($this->cx, $this->xBound-1),0);
				$this->cy += mt_rand(-8, +8);
				$this->cy = max(min($this->cy, $this->yBound-1),0);
				break;

			case 1:
				$this->x1 += mt_rand(-8, +8);
				$this->x1 = max(min($this->x1, $this->xBound-1),0);
				$this->y1 += mt_rand(-8, +8);
				$this->y1 = max(min($this->y1, $this->yBound-1),0);
				break;

			case 2:
				$this->x2 += mt_rand(-8, +8);
				$this->x2 = max(min($this->x2, $this->xBound-1),0);
				$this->y2 += mt_rand(-8, +8);
				$this->y2 = max(min($this->y2, $this->yBound-1),0);
				break;
		}

		// force to rasterize the new shape
		$this->lines = null;
	}

	public function rescale($xBound, $yBound){
		$xScale = ($xBound-1) / ($this->xBound-1);
		$yScale = ($yBound-1) / ($this->yBound-1);
		$this->xBound = $xBound;
		$this->yBound = $yBound;
		$this->cx = intval(round($this->cx*$xScale));
		$this->cy = intval(round($this->cy*$yScale));
		$this->x1 = intval(round($this->x1*$xScale));
		$this->y1 = intval(round($this->y1*$yScale));
		$this->x2 = intval(round($this->x2*$xScale));
		$this->y2 = intval(round($this->y2*$yScale));

		// need to rasterize again
		$this->lines = null;
	}


	public function getType(){
		return geometrize_shape_ShapeTypes::T_QUADRATIC_BEZIER;
	}

	/**
	 * @return array
	 */
	public function getRawShapeData(){
		return [
			$this->x1,
			$this->y1,
			$this->cx,
			$this->cy,
			$this->x2,
			$this->y2
		];
	}

	/**
	 * @return string
	 */
	public function getSvgShapeData(){
		return "<path d=\"M" . $this->x1 . "," . $this->y1 . "Q" . $this->cx . "," . $this->cy . " " . $this->x2 . "," . $this->y2 . "\" " . geometrize_exporter_SvgExporter::$SVG_STYLE_HOOK . " />";
	}

	public function __call($m, $a){
		if (isset($this->$m) && is_callable($this->$m)){
			return call_user_func_array($this->$m, $a);
		} else {
			if (isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m])){
				return call_user_func_array($this->__dynamics[$m], $a);
			} else {
				if ('toString'==$m){
					return $this->__toString();
				} else {
					throw new HException('Unable to call <' . $m . '>');
				}
			}
		}
	}

	function __toString(){
		return 'geometrize.shape.QuadraticBezier';
	}
}
