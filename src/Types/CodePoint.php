<?php

namespace Rattananen\Webdriver\Types;

/**
 * mostly nonpaintable code points
 * 
 * https://w3c.github.io/webdriver/#keyboard-actions
 * 
 * @final
 */
class CodePoint
{
    public const Unidentified = "\u{e000}";
    public const Cancel = "\u{e001}";
    public const Help = "\u{e002}";
    public const Backspace = "\u{e003}";
    public const Tab = "\u{e004}";
    public const Clear = "\u{e005}";
    public const Enter = "\u{e006}";
    public const NumpadEnter = "\u{e007}";
    public const Shift = "\u{e008}";
    public const Control = "\u{e009}";
    public const Alt = "\u{e00a}";
    public const Pause = "\u{e00b}";
    public const Escape = "\u{e00c}";
    public const Space = "\u{e00d}";
    public const PageUp = "\u{e00e}";
    public const PageDown = "\u{e00f}";
    public const End = "\u{e010}";
    public const Home = "\u{e011}";
    public const ArrowLeft = "\u{e012}";
    public const ArrowUp = "\u{e013}";
    public const ArrowRight = "\u{e014}";
    public const ArrowDown = "\u{e015}";
    public const Insert = "\u{e016}";
    public const Delete = "\u{e017}";
    public const Semicolon = "\u{e018}";
    public const Equal = "\u{e019}";
    public const Numpad0 = "\u{e01a}";
    public const Numpad1 = "\u{e01b}";
    public const Numpad2 = "\u{e01c}";
    public const Numpad3 = "\u{e01d}";
    public const Numpad4 = "\u{e01e}";
    public const Numpad5 = "\u{e01f}";
    public const Numpad6 = "\u{e020}";
    public const Numpad7 = "\u{e021}";
    public const Numpad8 = "\u{e022}";
    public const Numpad9 = "\u{e023}";
    public const NumpadMultiply = "\u{e024}";
    public const NumpadAdd = "\u{e025}";
    public const NumpadComma = "\u{e026}";
    public const NumpadSubtract = "\u{e027}";
    public const NumpadDecimal = "\u{e028}";
    public const NumpadDivide = "\u{e029}";
    public const F1 = "\u{e031}";
    public const F2 = "\u{e032}";
    public const F3 = "\u{e033}";
    public const F4 = "\u{e034}";
    public const F5 = "\u{e035}";
    public const F6 = "\u{e036}";
    public const F7 = "\u{e037}";
    public const F8 = "\u{e038}";
    public const F9 = "\u{e039}";
    public const F10 = "\u{e03a}";
    public const F11 = "\u{e03b}";
    public const F12 = "\u{e03c}";
    public const Meta = "\u{e03d}";
    public const ZenkakuHankaku = "\u{E040}";
    public const ShiftRight = "\u{e050}";
    public const ControlRight = "\u{e051}";
    public const AltRight = "\u{e052}";
    public const MetaRight = "\u{e053}";
    public const NumpadPageUp = "\u{e054}";
    public const NumpadPageDown = "\u{e055}";
    public const NumpadEnd = "\u{e056}";
    public const NumpadHome = "\u{e057}";
    public const NumpadLeft = "\u{e058}";
    public const NumpadUp = "\u{e059}";
    public const NumpadRight = "\u{e05a}";
    public const NumpadDown = "\u{e05b}";
    public const NumpadInsert = "\u{e05c}";
    public const NumpadDelete = "\u{e05d}";
}
