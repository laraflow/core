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
     */
    public function map($row): array;

    /**
     * @return mixed
     */
    public function setBorderStyle($borderBuilder);

    /**
     * @return mixed
     */
    public function setRowStyle($styleBuilder);

    /**
     * @return mixed
     */
    public function setHeadingStyle($styleBuilder);
}
