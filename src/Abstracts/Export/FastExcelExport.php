<?php

namespace Laraflow\Core\Abstracts\Export;

use InvalidArgumentException;
use Laraflow\Core\Interfaces\ExportInterface;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Writer\Common\Creator\Style\BorderBuilder;
use OpenSpout\Writer\Common\Creator\Style\StyleBuilder;
use Rap2hpoutre\FastExcel\FastExcel;

abstract class FastExcelExport extends FastExcel implements ExportInterface
{
    /**
     * @var array
     */
    public $formatRow = [];

    /**
     * @var BorderBuilder
     */
    protected $borderStyle;

    /**
     * @var StyleBuilder
     */
    protected $headingStyle;

    /**
     * @var StyleBuilder
     */
    protected $rowStyle;

    /**
     * Export Constructor
     *
     * @throws InvalidArgumentException|\OpenSpout\Common\Exception\InvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct();

        $this->setHeadingStyle((new StyleBuilder())
            ->setFontBold()
            ->setFontSize(12)
            ->setFontColor(Color::WHITE)
            ->setShouldWrapText()
            ->setBackgroundColor(Color::BLACK)
            ->setCellAlignment(CellAlignment::CENTER));

        $this->setBorderStyle((new BorderBuilder())
            ->setBorderTop(Color::BLACK, Border::WIDTH_MEDIUM)
            ->setBorderRight(Color::BLACK, Border::WIDTH_MEDIUM)
            ->setBorderBottom(Color::BLACK, Border::WIDTH_MEDIUM)
            ->setBorderLeft(Color::BLACK, Border::WIDTH_MEDIUM));

        $this->setRowStyle((new StyleBuilder())
            ->setFontSize(12)
            ->setShouldWrapText()
            ->setCellAlignment(CellAlignment::LEFT));
    }

    /**
     * @param  StyleBuilder  $styleBuilder
     */
    public function setHeadingStyle($styleBuilder): self
    {
        //add Border Style for excel and ods
        if ($this->borderStyle instanceof BorderBuilder) {
            $borderStyle = $this->borderStyle->build();
            $styleBuilder->setBorder($borderStyle);
        }

        $style = $styleBuilder->build();

        $this->headerStyle($style);

        return $this;
    }

    /**
     * @param  BorderBuilder  $borderBuilder
     */
    public function setBorderStyle($borderBuilder): self
    {
        $this->borderStyle = $borderBuilder;

        return $this;
    }

    /**
     * @param  StyleBuilder  $styleBuilder
     */
    public function setRowStyle($styleBuilder): self
    {
        //add Border Style for excel and ods
        if ($this->borderStyle instanceof BorderBuilder) {
            $borderStyle = $this->borderStyle->build();
            $styleBuilder->setBorder($borderStyle);
        }

        $style = $styleBuilder->build();

        $this->rowsStyle($style);

        return $this;
    }

    /**
     * Modify Output Row Cells
     *
     * @param  mixed  $row
     */
    abstract public function map($row): array;
}
