<?php

namespace AppBundle\Utils;

/**
 * Class Datatable
 * @package AppBundle\Utils
 */
class Datatable
{

    /**
     * Liste de toutes les colonnes
     *
     * @var array
     */
    private $tColumns;

    /**
     * tableau d'index des colonnes à afficher
     *
     * @var array
     */
    private $tIndexColumns;

    /**
     * tableau de colonnes + options du datatable
     *
     * @var array
     */
    private $columnOption;

    /**
     * tableau de libelles des colonnes à afficher
     *
     * @var array
     */
    private $tLibelleAffiches;

    /**
     * tableau de libelles des colonnes masquées
     *
     * @var array
     */
    private $tLibelleMasques;

    /**
     *
     * @var bool
     */
    private $checkboxOption = true;

    /**
     * Construct
     *
     * @param array $tAllColumns   liste de toutes les colonnes du datatable
     * @param array $tIndexColumns tableau d'index des colonnes à afficher
     */
    public function __construct($tAllColumns, $tIndexColumns, $checkboxOption = true)
    {
        $this->tColumns = $tAllColumns;
        $this->tIndexColumns = $tIndexColumns;
        $this->checkboxOption = $checkboxOption;
        $this->createColumnOption();
    }

    /**
     * return un tableau de libelle des colonnes à afficher
     *
     * @return array
     */
    public function getLabelColAffichees()
    {
        return $this->tLibelleAffiches;
    }

    /**
     * return un tableau de libelle des colonnes invisibles
     *
     * @return array
     */
    public function getLabelColMasquees()
    {
        return $this->tLibelleMasques;
    }

    /**
     * return un tableau de colonnes + options
     *
     * @return array
     */
    public function getColumnOption()
    {
        return $this->columnOption;
    }

    /**
     *
     * @param type $title
     * @param type $dataCible
     * @param type $params
     *
     * @return array
     */
    public static function generateHeader($title, $dataCible, $params = array())
    {
        return array_merge($params, array('sTitle' => $title, 'mData' => $dataCible));
    }

    /**
     *
     * @param type $pattern
     * @param type $subject
     *
     * @return type
     */
    public static function extractData($pattern, $subject)
    {
        preg_match_all($pattern, $subject, $data);

        return $data;
    }

    /**
     *
     * @param type $data
     *
     * @return type
     */
    public static function getHeader($data)
    {
        $header = preg_replace('[<th(.*)>|\n|\s{2}]', '', $data);

        return preg_split('[</th>]', $header);
    }

    /**
     * checkbox options
     *
     *
     * @return \stdClass
     */
    private function addCheckbox()
    {
        $column = new \stdClass();
        $column->bSortable = 0;
        $column->sWidth = '1%';
        $column->mData = 'checkbox';

        return $column;
    }

    /**
     * actions options
     *
     * @return \stdClass
     */
    private function addAction()
    {
        $column = new \stdClass();
        $column->bSortable = 0;
        $column->sWidth = '5%';
        $column->mData = 'info';

        return $column;
    }

    /**
     * tableau d'options de colonnes
     *
     * @return array
     */
    private function createColumnOption()
    {
        foreach ($this->tIndexColumns as $column) {
            $options = $this->tColumns[$column];
            $this->tLibelleAffiches[$column] = $options['label'];
        }

        $tOColumns = array();

        if ($this->checkboxOption) {
            $tOColumns[] = $this->addCheckbox();
        }

        foreach ($this->tColumns as $index => $options) {
            if (in_array($index, $this->tIndexColumns)) {
                $i = array_search($index, $this->tIndexColumns);
                $column = new \stdClass();
                foreach ($options as $key => $option) {
                    if (trim($key) != 'label') {
                        $column->$key = $option;
                    }
                }
                $i = $this->checkboxOption == true ? $i+1: $i;
                $tOColumns[$i] = $column;
            } else {
                $this->tLibelleMasques[$index] = $options['label'];
            }
        }

        $tOColumns[] = $this->addAction();
        ksort($tOColumns);
        $this->columnOption = $tOColumns;
    }
}
