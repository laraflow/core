<?php

namespace Laraflow\Core\Interfaces;

/**
 * Interface ExportInterface
 */
interface ExportInterface
{
    /**
     * Modify Output Row Cells
     *
     * @param  mixed  $row
     * @return array
     */
    public function map($row): array;

    /**
     * @param $borderBuilder
     * @return mixed
     */
    public function setBorderStyle($borderBuilder);

    /**
     * @param $styleBuilder
     * @return mixed
     */
    public function setRowStyle($styleBuilder);

    /**
     * @param $styleBuilder
     * @return mixed
     */
    public function setHeadingStyle($styleBuilder);
}
