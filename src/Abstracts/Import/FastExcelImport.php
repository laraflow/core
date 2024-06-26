<?php

namespace Laraflow\Core\Abstracts\Import;

use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Laraflow\Core\Interfaces\ExportInterface;
use Rap2hpoutre\FastExcel\FastExcel;

abstract class FastExcelImport extends FastExcel implements ExportInterface
{
    /**
     * @var array
     */
    public $formatRow = [];

    /**
     * @var BorderBuilder
     */
    protected $borderStyle = null;

    /**
     * @var StyleBuilder
     */
    protected $headingStyle = null;

    /**
     * @var StyleBuilder
     */
    protected $rowStyle = null;

    /**
     * Export Constructor
     *
     * @throws InvalidArgumentException
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
            ->setBorderTop(Color::RED, Border::WIDTH_THIN)
            ->setBorderRight(Color::RED, Border::WIDTH_THIN)
            ->setBorderBottom(Color::RED, Border::WIDTH_THIN)
            ->setBorderLeft(Color::RED, Border::WIDTH_THIN));

        $this->setRowStyle((new StyleBuilder())
            ->setFontSize(12)
            ->setShouldWrapText()
            ->setCellAlignment(CellAlignment::LEFT));
    }

    public function setHeadingStyle(StyleBuilder $styleBuilder): self
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

    public function setBorderStyle(BorderBuilder $borderBuilder): self
    {
        $this->borderStyle = $borderBuilder;

        return $this;
    }

    public function setRowStyle(StyleBuilder $styleBuilder): self
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
