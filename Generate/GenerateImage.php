<?php

require_once 'TileTypes.php';

class GenerateImage
{
    /**
     * Scene size
     */
    protected int $width = 100;
    protected int $height = 50;

    /**
     * Tile size
     */
        protected int $tileSize = 32;

    /**
     * World matrix
     */
    protected array $world = [];

    /**
     * Should we overwrite existing saved images?
     */
    protected bool $overrideImages = true;

    protected string $fileName = 'test';

    /**
     * @throws Exception
     */
    public function generate(string $fileName): self
    {
        $pathGenerated = APP_PATH.'/generated/';

        $pathToFile = $pathGenerated.$fileName.'.png';

        if (file_exists($pathToFile) && $this->overrideImages === false) {
            throw new Exception('Image already exist');
        }

        $image = imagecreatetruecolor($this->getWidth(), $this->getHeight());

        $this->fileName = $fileName;

        $this->generateWorld();
        $this->drawWorld($image);

        imagepng($image, $pathToFile);
        imagedestroy($image);

        return $this;
    }

    public function displayWorld(): string
    {
        $image = APP_PATH.'/generated/'.$this->fileName.'.png';

        if (!file_exists($image)) {
            throw new Exception('Not found image');
        }

        return '<div class="image"><img src="generated/'.$this->fileName.'.png" /></div>';
    }

    /**
     * @throws Exception
     */
    private function generateWorld(): void
    {
        for ($y = 0; $y < $this->height; $y++) {
            $this->world[$y] = array_fill( 0, $this->width, TileTypes::TILE_DEFAULT );
        }

        $blueStarCount = ($this->width * $this->height) * 0.03;

        for ($c = 0; $c < $blueStarCount; $c++) {
            $startX = random_int(0, $this->width);
            $startY = random_int(0, $this->height);

            $endX = $startX;
            $endY = $startY;

            for ($y = $startY; $y <= $endY; $y++) {
                for ($x = $startX; $x <= $endX; $x++) {
                    $this->world[$y][$x] = TileTypes::TILE_BLUE_STAR;
                }
            }
        }

        $starCount = ($this->width * $this->height) * 0.03;

        for ($c = 0; $c < $starCount; $c++) {
            $startX = random_int(0, $this->width);
            $startY = random_int(0, $this->height);

            $endX = $startX;
            $endY = $startY;

            for ($y = $startY; $y <= $endY; $y++) {
                for ($x = $startX; $x <= $endX; $x++) {
                    $this->world[$y][$x] = TileTypes::TILE_STAR;
                }
            }
        }

        $rocketPercent = 1 / random_int(0, 100);

        $rocketCount = 1;

        if ($rocketPercent > 0.95) {
            for ($c = 0; $c < $rocketCount; $c++) {
                $startX = random_int(0, $this->width);
                $startY = random_int(0, $this->height);

                $endX = $startX;
                $endY = $startY;

                for ($y = $startY; $y <= $endY; $y++) {
                    for ($x = $startX; $x <= $endX; $x++) {
                        $this->world[$y][$x] = TileTypes::TILE_ROCKET;
                    }
                }
            }
        }

        $bluePlanetCount = ($this->width * $this->height) * 0.006;

        for ($c = 0; $c < $bluePlanetCount; $c++) {
            $startX = random_int(0, $this->width);
            $startY = random_int(0, $this->height);

            $endX = $startX;
            $endY = $startY;

            for ($y = $startY; $y <= $endY; $y++) {
                for ($x = $startX; $x <= $endX; $x++) {
                    $this->world[$y][$x] = TileTypes::TILE_BLUE_PLANET;
                }
            }
        }

        $orangePlanetCount = ($this->width * $this->height) * 0.008;

        for ($c = 0; $c < $orangePlanetCount; $c++) {
            $startX = random_int(0, $this->width);
            $startY = random_int(0, $this->height);

            $endX = $startX;
            $endY = $startY;

            for ($y = $startY; $y <= $endY; $y++) {
                for ($x = $startX; $x <= $endX; $x++) {
                    $this->world[$y][$x] = TileTypes::TILE_ORANGE_PLANET;
                }
            }
        }

        $whiteStarCount = ($this->width * $this->height) * 0.06;

        for ($c = 0; $c < $whiteStarCount; $c++) {
            $startX = random_int(0, $this->width);
            $startY = random_int(0, $this->height);

            $endX = $startX;
            $endY = $startY;

            for ($y = $startY; $y <= $endY; $y++) {
                for ($x = $startX; $x <= $endX; $x++) {
                    $this->world[$y][$x] = TileTypes::TILE_WHITE_STARS;
                }
            }
        }
    }

    private function drawWorld($image): void
    {
        for( $y = 0; $y < $this->height; $y ++ ) {
            for( $x = 0; $x < $this->width; $x ++ ) {

                $tile_x_position = $x * $this->tileSize;
                $tile_y_position = $y * $this->tileSize;

                $this->drawTile($image, $this->world[$y][$x], $tile_x_position, $tile_y_position );
            }
        }
    }

    /**
     * @throws Exception
     */
    private function drawTile($image, int $tileType, int $positionX, int $positionY): void
    {
        $tile = [0, 0];

        if ((TileTypes::TILE_DEFAULT === $tileType) && random_int(0, 100) > 50) {
            $tile = [0, 0];
        }

        if (TileTypes::TILE_BLUE_STAR === $tileType) {
            $tile = [0, 0];
        }

        imagecopyresized(
            $image, $this->getTileImage($tileType),						// images.
            $positionX, $positionY,									// position on the image we are drawing.
            $tile[0] * $this->tileSize,					// X position of the tile to draw.
            $tile[1] * $this->tileSize,					// Y position of the tile to draw.
            $this->tileSize, $this->tileSize,		// Dimensions to copy the tile to.
            $this->tileSize, $this->tileSize					// Size of the tile on the source image.
        );
    }

    private function getWidth(): int
    {
        return $this->width * $this->tileSize;
    }

    private function getHeight(): int
    {
        return $this->height * $this->tileSize;
    }

    /**
     * @return false|GdImage|resource
     */
    private function getTileImage(string $type)
    {
        $tiles = [
            TileTypes::TILE_DEFAULT => 'default',
            TileTypes::TILE_BLUE_STAR => 'blue_star',
            TileTypes::TILE_STAR => 'star',
            TileTypes::TILE_ROCKET => 'rocket',
            TileTypes::TILE_ORANGE_PLANET => 'orange_planet',
            TileTypes::TILE_BLUE_PLANET => 'blue_planet',
            TileTypes::TILE_WHITE_STARS => 'white_star',
        ];

        return imagecreatefrompng( APP_PATH.'/tiles/'.$tiles[$type].'.png' );
    }
}