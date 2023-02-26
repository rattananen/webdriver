<?php

namespace Rattananen\Webdriver\Input\Actions\Traits;

trait PointerTrait
{
    /** 
     * @var float|null $width >= 0 
     */
    public ?float $width = null;

    /** 
     * @var float|null $height >= 0
     */
    public ?float $height = null;

    /** 
     * @var float|null $pressure 0 - 1
     */
    public ?float $pressure = null;

    /** 
     * @var float|null $tangentialPressure -1 - 1
     */
    public ?float $tangentialPressure = null;

    /** 
     * @var int|null $tiltX -90 - 90
     */
    public ?int $tiltX = null;

    /** 
     * @var int|null $tiltY -90 - 90
     */
    public ?int $tiltY = null;

    /** 
     * @var int|null $twist 0 - 359
     */
    public ?int $twist = null;

    /** 
     * @var float|null $altitudeAngle 0 - pi/2
     */
    public ?float $altitudeAngle = null;

    /** 
     * @var float|null $azimuthAngle 0 - 2pi
     */
    public ?float $azimuthAngle = null;


    public function getOptions(): array
    {
        $out =  [];
        if (isset($this->width)) {
            $out['width'] = $this->width;
        }
        if (isset($this->height)) {
            $out['height'] = $this->height;
        }
        if (isset($this->pressure)) {
            $out['pressure'] = $this->pressure;
        }
        if (isset($this->tangentialPressure)) {
            $out['tangentialPressure'] = $this->tangentialPressure;
        }
        if (isset($this->tiltX)) {
            $out['tiltX'] = $this->tiltX;
        }
        if (isset($this->tiltY)) {
            $out['tiltY'] = $this->tiltY;
        }
        if (isset($this->twist)) {
            $out['twist'] = $this->twist;
        }
        if (isset($this->altitudeAngle)) {
            $out['altitudeAngle'] = $this->altitudeAngle;
        }
        if (isset($this->azimuthAngle)) {
            $out['azimuthAngle'] = $this->azimuthAngle;
        }
        return $out;
    }
}
