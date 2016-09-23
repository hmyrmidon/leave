<?php

namespace AppBundle\Twig;

use AppBundle\Entity\VacationRequest;
use AppBundle\Manager\HolidayManager;
use Doctrine\ORM\EntityManager;

class ProjectExtension extends \Twig_Extension
{
    private $entityManager;
    private $services;

    public function __construct(EntityManager $entityManager, $params)
    {
        $this->entityManager = $entityManager;
        $this->services      = $params['services'];
    }

    public function getName()
    {
        return 'project';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('dayCount', [$this, 'dateDiff']),
            new \Twig_SimpleFilter('status', [$this, 'status']),
            new \Twig_SimpleFilter('delete', [$this, 'addDeleteButtonByStatus']),
            new \Twig_SimpleFilter('format_number', [$this, 'formatNumber']),
            new \Twig_SimpleFilter('tostring', array($this, 'toString')),
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('addButton', [$this, 'addButton'])
        ];
    }

    public function dateDiff($value, $otherDate)
    {
        /**
         * @var HolidayManager $holiday
         */
        $holiday   = $this->services['holiday'];
        $dateStart = $value instanceof \DateTime ? $value->format('Y-m-d'): $value;
        $dateEnd   = $otherDate instanceof \DateTime ? $otherDate->format('Y-m-d') : $otherDate;
        return $holiday->getDayCount($dateStart, $dateEnd);
    }

    public function status($value)
    {
        $element = '';
        switch ($value){
            case VacationRequest::VALIDATE_STATUS:
                $element = '<i class="fa fa-check fa-lg green"></i>';
                break;
            case VacationRequest::DENIED_STATUS:
                $element = '<i class="fa fa-close fa-lg red"></i>';
                break;
            default:
                $element = '<i class="fa fa-refresh fa-lg purple"></i>';
                break;
        }

        return $element;
    }

    /**
     * @param $icon
     * @param $url
     * @param $color
     * @param $label
     *
     * @return string
     */
    public function addButton($icon, $url, $label, $btnClass, $extraParams='')
    {
        return sprintf('<a href="%s" class="%s" title="%s" %s><i class="%s"></i></a>', $url, $btnClass, $label, $extraParams, $icon);
    }

    public function addDeleteButtonByStatus($status, $btnExtraParam)
    {
        if($status == VacationRequest::PENDING_STATUS){
            return $this->addButton('fa fa-times', '#', 'Supprimer',
                'btn btn-danger btn-xs btn-delete',
                $btnExtraParam);
        }
    }

    public function formatNumber($value, $format)
    {
        return vsprintf($format, $value);
    }

    public function toString($objects, $attribute = 'name') 
    { 
        $result = [];
        $method = 'get' . ucfirst($attribute);
        if (is_array($objects)) {
            foreach ($objects as $object) {
                if (method_exists($object, $method)) {
                    $result[] = $object->{$method}();
                }
            }
        } else {
            if (method_exists($objects, $method)) {
                $result[] = $objects->{$method}();
            }
        }
        return implode(', ', $result);
    }

}