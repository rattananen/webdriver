<?php

namespace Rattananen\Webdriver\Types;

/**
 * https://www.w3.org/TR/uievents/#dom-mouseevent-button
 */
enum PointerButton: int
{
    /**
     * usually left button or single button device or finger
     */
    case primary = 0;

    /**
     * usually middle button
     */
    case auxiliary = 1;

    /**
     * usually right button
     */
    case secondary = 2;

    /**
     * back button
     */
    case x1 = 3;

    /**
     * forward button
     */
    case x2 = 4;
}
