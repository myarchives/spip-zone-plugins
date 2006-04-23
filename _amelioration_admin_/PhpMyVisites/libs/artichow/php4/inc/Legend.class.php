<?php
/*
 * This work is hereby released into the Public Domain.
 * To view a copy of the public domain dedication,
 * visit http://creativecommons.org/licenses/publicdomain/ or send a letter to
 * Creative Commons, 559 Nathan Abbott Way, Stanford, California 94305, USA.
 *
 */

 
/* <php4> */

define("LEGEND_LINE", 1);
define("LEGEND_BACKGROUND", 2);
define("LEGEND_MARK", 3);
define("LEGEND_MARKONLY", 4);

define("LEGEND_MODEL_RIGHT", 1);
define("LEGEND_MODEL_BOTTOM", 2);

define("LEGEND_LEFT", 1);
define("LEGEND_RIGHT", 2);
define("LEGEND_CENTER", 3);
define("LEGEND_TOP", 4);
define("LEGEND_BOTTOM", 5);
define("LEGEND_MIDDLE", 6);

/* </php4> */

/**
 * Some legends
 *
 * @package Artichow
 */
class awLegend {

	/**
	 * Legends added
	 *
	 * @var array
	 */
	var $legends = array();

	/**
	 * The current component
	 *
	 * @var Component
	 */
	var $component;
	
	/**
	 * Background color or gradient
	 *
	 * @var Color, Gradient
	 */
	var $background;
	
	/**
	 * Text color
	 *
	 * @var Color
	 */
	var $textColor;
	
	/**
	 * Text font
	 *
	 * @var Font
	 */
	var $textFont;
	
	/**
	 * Text margin
	 *
	 * @var Side
	 */
	var $textMargin;
	
	/**
	 * Number of columns
	 *
	 * @var int
	 */
	var $columns = NULL;
	
	/**
	 * Number of rows
	 *
	 * @var int
	 */
	var $rows = NULL;
	
	/**
	 * Legend position
	 *
	 * @var Point
	 */
	var $position;
	
	/**
	 * Hide legend ?
	 *
	 * @var bool
	 */
	var $hide = FALSE;
	
	/**
	 * Space between each legend
	 *
	 * @var int
	 */
	var $space = 4;
	
	/**
	 * Horizontal alignment
	 *
	 * @var int
	 */
	var $hAlign;
	
	/**
	 * Vertical alignment
	 *
	 * @var int
	 */
	var $vAlign;

	/**
	 * Margin
	 *
	 * @var array Array for left, right, top and bottom margins
	 */
	var $margin;
	
	/**
	 * Legend shadow
	 *
	 * @var Shadow
	 */
	var $shadow;
	
	/**
	 * Legend border
	 *
	 * @var Border
	 */
	var $border;
	
	/**
	 * Line legend
	 *
	 * @var int
	 */
	
	
	/**
	 * Color/Gradient background legend
	 *
	 * @var int
	 */
	
	
	/**
	 * Use marks and line as legend
	 *
	 * @var int
	 */
	
	
	/**
	 * Use marks as legend
	 *
	 * @var int
	 */
	
	
	/**
	 * Right side model
	 *
	 * @var int
	 */
	
	
	/**
	 * Bottom side model
	 *
	 * @var int
	 */
	

	/**
	 * Build the legend
	 *
	 * @param int $model Legend model
	 */
	 function awLegend($model = LEGEND_MODEL_RIGHT) {
	
		$this->shadow = new awShadow(SHADOW_LEFT_BOTTOM);
		$this->border = new awBorder;
		
		$this->textMargin = new awSide(4);
		$this->setModel($model);
		
	}
	
	/**
	 * Set a predefined model for the legend
	 *
	 * @param int $model
	 */
	 function setModel($model) {
		
		$this->setBackgroundColor(new awColor(255, 255, 255, 15));
		$this->setPadding(8, 8, 8, 8);
		$this->setTextFont(new awFont2);
		$this->shadow->setSize(3);
	
		switch($model) {
		
			case LEGEND_MODEL_RIGHT :
			
				$this->setColumns(1);
				$this->setAlign(LEGEND_RIGHT, LEGEND_MIDDLE);
				$this->setPosition(0.96, 0.50);
			
				break;
		
			case LEGEND_MODEL_BOTTOM :
			
				$this->setRows(1);
				$this->setAlign(LEGEND_CENTER, LEGEND_TOP);
				$this->setPosition(0.50, 0.92);
			
				break;
				
			default :
			
				$this->setPosition(0.5, 0.5);
				
				break;
		
		}
	
	}
	
	/**
	 * Hide legend ?
	 *
	 * @param bool $hide TRUE to hide legend, FALSE otherwise
	 */
	 function hide($hide = TRUE) {
		$this->hide = (bool)$hide;
	}
	
	/**
	 * Show legend ?
	 *
	 * @param bool $show
	 */
	 function show($show = TRUE) {
		$this->hide = (bool)!$show;
	}
	
	
	/**
	 * Add a Legendable object to the legend
	 *
	 * @param &$legendable
	 * @param string $title Legend title
	 * @param int $type Legend type (default to LEGEND_LINE)
	 */
	 function add(&$legendable, $title, $type = LEGEND_LINE) {
	
		$legend = array($legendable, $title, $type);
	
		$this->legends[] = $legend;
		
	}
	
	/**
	 * Change legend padding
	 *
	 * @param int $left
	 * @param int $right
	 * @param int $top
	 * @param int $bottom
	 */
	 function setPadding($left, $right, $top, $bottom) {
		$this->padding = array((int)$left, (int)$right, (int)$top, (int)$bottom);
	}
	
	/**
	 * Change space between each legend
	 *
	 * @param int $space
	 */
	 function setSpace($space) {
		$this->space = (int)$space;
	}
	
	/**
	 * Change alignment
	 *
	 * @param int $h Horizontal alignment
	 * @param int $v Vertical alignment
	 */
	 function setAlign($h = NULL, $v = NULL) {
		if($h !== NULL) {
			$this->hAlign = (int)$h;
		}
		if($v !== NULL) {
			$this->vAlign = (int)$v;
		}
	}
	
	/**
	 * Change number of columns
	 *
	 * @param int $columns
	 */
	 function setColumns($columns) {
		$this->rows = NULL;
		$this->columns = (int)$columns;
	}
	
	/**
	 * Change number of rows
	 *
	 * @param int $rows
	 */
	 function setRows($rows) {
		$this->columns = NULL;
		$this->rows = (int)$rows;
	}
	
	/**
	 * Change legend position
	 * X and Y positions must be between 0 and 1.
	 *
	 * @param float $x
	 * @param float $y
	 */
	 function setPosition($x = NULL, $y = NULL) {
		$x = (is_null($x) and !is_null($this->position)) ? $this->position->x : $x;
		$y = (is_null($y) and !is_null($this->position)) ? $this->position->y : $y;
		
		$this->position = new awPoint($x, $y);
	}
	
	/**
	 * Get legend position
	 *
	 * @return Point
	 */
	 function getPosition() {
		return $this->position;
	}
	
	/**
	 * Change text font
	 *
	 * @param &$font
	 */
	 function setTextFont(&$font) {
		$this->textFont = $font;
	}
	
	/**
	 * Change text margin
	 *
	 * @param int $left
	 * @param int $right
	 */
	 function setTextMargin($left, $right) {
		$this->textMargin->set($left, $right);
	}
	
	/**
	 * Change text color
	 *
	 * @param $color
	 */
	 function setTextColor($color) {
		$this->textColor = $color;
	}
	
	/**
	 * Change background
	 *
	 * @param mixed $background
	 */
	 function setBackground($background) {
		$this->background = $background;
	}
	
	/**
	 * Change background color
	 *
	 * @param $color
	 */
	 function setBackgroundColor($color) {
		$this->background = $color;
	}
	
	/**
	 * Change background gradient
	 *
	 * @param $gradient
	 */
	 function setBackgroundGradient($gradient) {
		$this->background = $gradient;
	}
	
	/**
	 * Count the number of Legendable objects in the legend
	 *
	 * @return int
	 */
	 function count() {
		return count($this->legends);
	}
	
	 function draw($drawer) {
		
		if($this->hide) {
			return;
		}
	
		$count = $this->count();
		
		// No legend to print
		if($count === 0) {
			return;
		}
		
		// Get text widths and heights of each element of the legend
		$widths = array();
		$heights = array();
		$texts = array();
		for($i = 0; $i < $count; $i++) {
			list(, $title, ) = $this->legends[$i];
			$text = new awText(
				$title,
				$this->textFont,
				$this->textColor,
				0
			);
			$font = $text->getFont();
			$widths[$i] = $font->getTextWidth($text) + $this->textMargin->left + $this->textMargin->right;
			$heights[$i] = $font->getTextHeight($text);
			$texts[$i] = $text;
		}
		
		// Maximum height of the font used
		$heightMax = array_max($heights);
		
		// Get number of columns
		if($this->columns !== NULL) {
			$columns = $this->columns;
		} else if($this->rows !== NULL) {
			$columns = ceil($count / $this->rows);
		} else {
			$columns = $count;
		}
		
		// Number of  rows
		$rows = (int)ceil($count / $columns);
		
		// Get maximum with of each column
		$widthMax = array();
		for($i = 0; $i < $count; $i++) {
			// Get column width
			$column = $i % $columns;
			if(array_key_exists($column, $widthMax) === FALSE) {
				$widthMax[$column] = $widths[$i];
			} else {
				$widthMax[$column] = max($widthMax[$column], $widths[$i]);
			}
		}
		
		$width = $this->padding[0] + $this->padding[1] - $this->space;
		for($i = 0; $i < $columns; $i++) {
			$width += $this->space + 5 + 10 + $widthMax[$i];
		}
		
		$height = ($heightMax + $this->space) * $rows - $this->space + $this->padding[2] + $this->padding[3];
		
		// Look for legends position
		list($x, $y) = $drawer->getSize();
		
		$p = new awPoint(
			$this->position->x * $x,
			$this->position->y * $y
		);
		
		switch($this->hAlign) {
		
			case LEGEND_CENTER :
				$p->x -= $width / 2;
				break;
		
			case LEGEND_RIGHT :
				$p->x -= $width;
				break;
		
		}
		
		switch($this->vAlign) {
		
			case LEGEND_MIDDLE :
				$p->y -= $height / 2;
				break;
		
			case LEGEND_BOTTOM :
				$p->y -= $height;
				break;
		
		}
		
		// Draw legend shadow
		$this->shadow->draw(
			$drawer,
			$p,
			$p->move($width, $height),
			SHADOW_OUT
		);
		
		// Draw legends base
		$this->drawBase($drawer, $p, $width, $height);
		
		// Draw each legend
		for($i = 0; $i < $count; $i++) {
		
			list($component, $title, $type) = $this->legends[$i];
		
			$column = $i % $columns;
			$row = (int)floor($i / $columns);
			
			// Get width of all previous columns
			$previousColumns = 0;
			for($j = 0; $j < $column; $j++) {
				$previousColumns += $this->space + 10 + 5 + $widthMax[$j];
			}
			
			// Draw legend text
			$drawer->string(
				$texts[$i],
				$p->move(
					$this->padding[0] + $previousColumns + 10 + 5 + $this->textMargin->left,
					$this->padding[2] + $row * ($heightMax + $this->space) + $heightMax / 2 - $heights[$i] / 2
				)
			);
			
			// Draw legend icon
			switch($type) {
			
				case LEGEND_LINE :
				case LEGEND_MARK :
				case LEGEND_MARKONLY :
				
					// Get vertical position
					$x = $this->padding[0] + $previousColumns;
					$y = $this->padding[2] + $row * ($heightMax + $this->space) + $heightMax / 2 - $component->getLegendLineThickness();
					
					// Draw two lines
					if($component->getLegendLineColor() !== NULL) {
					
						$color = $component->getLegendLineColor();
				
						if(is_a($color, 'awColor') and $type !== LEGEND_MARKONLY) {
						
							$drawer->line(
								$color,
								new awLine(
									$p->move(
										$x, // YaPB ??
										$y + $component->getLegendLineThickness() / 2
									),
									$p->move(
										$x + 10,
										$y + $component->getLegendLineThickness() / 2
									),
									$component->getLegendLineStyle(),
									$component->getLegendLineThickness()
								)
							);
						
							$color->free();
							unset($color);
							
						}
						
					}
					
					if($type === LEGEND_MARK or $type === LEGEND_MARKONLY)  {
					
						$mark = $component->getLegendMark();
					
						if($mark !== NULL) {
							$mark->draw(
								$drawer,
								$p->move(
									$x + 5.5,
									$y + $component->getLegendLineThickness() / 2
								)
							);
						}
						
						unset($mark);
					
					}
					
					break;
					
				case LEGEND_BACKGROUND :
				
					// Get vertical position
					$x = $this->padding[0] + $previousColumns;
					$y = $this->padding[2] + $row * ($heightMax + $this->space) + $heightMax / 2 - 5;
					
					$from = $p->move(
						$x,
						$y
					);
					
					$to = $p->move(
						$x + 10,
						$y + 10
					);
					
					$background = $component->getLegendBackground();
					
					if($background !== NULL) {
				
						$drawer->filledRectangle(
							$background,
							new awLine($from, $to)
						);
			
						// Draw rectangle border
						$this->border->rectangle(
							$drawer,
							$from->move(0, 0),
							$to->move(0, 0)
						);
						
					}
					
					unset($background, $from, $to);
				
					break;
			
			}
		
		}
	
	}
	
	 function drawBase($drawer, $p, $width, $height) {

		$this->border->rectangle(
			$drawer,
			$p,
			$p->move($width, $height)
		);
		
		$size = $this->border->visible() ? 1 : 0;
		
		$drawer->filledRectangle(
			$this->background,
			new awLine(
				$p->move($size, $size),
				$p->move($width - $size, $height - $size)
			)
		);
		
	}

}

registerClass('Legend');

/**
 * You can add a legend to components which implements this interface
 *
 * @package Artichow
 */


registerInterface('Legendable');
?>