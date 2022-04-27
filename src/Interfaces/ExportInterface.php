<?php

namespace Laraflow\Laraflow\Interfaces;

use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;

/**
 * Interface ExportInterface
 * @package Laraflow\Laraflow\Interfaces
 */
interface ExportInterface
{
    /**
     * Modify Output Row Cells
     *
     * @param mixed $row
     * @return array
     */
    public function map($row): array;

    /**
     * @param BorderBuilder $borderBuilder
     * @return mixed
     */
    public function setBorderStyle(BorderBuilder $borderBuilder);

    /**
     * @param StyleBuilder $styleBuilder
     * @return mixed
     */
    public function setRowStyle(StyleBuilder $styleBuilder);

    /**
     * @param StyleBuilder $styleBuilder
     * @return mixed
     */
    public function setHeadingStyle(StyleBuilder $styleBuilder);
}
