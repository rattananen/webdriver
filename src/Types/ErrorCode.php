<?php

namespace Rattananen\Webdriver\Types;

/**
 * @see https://www.w3.org/TR/webdriver/#dfn-error-code
*/
enum ErrorCode: string
{
    case ElementClickIntercepted = 'element click intercepted';
    case ElementNotInteractable = 'element not interactable';
    case InsecureCertificate = 'insecure certificate';
    case InvalidArgument = 'invalid argument';
    case InvalidCookieDomain = 'invalid cookie domain';
    case InvalidElementState = 'invalid element state';
    case InvalidSelector = 'invalid selector';
    case InvalidSessionId = 'invalid session id';
    case JavascriptError = 'javascript error';
    case MoveTargetOutOfBounds = 'move target out of bounds';
    case NoSuchAlert = 'no such alert';
    case NoSuchCookie = 'no such cookie';
    case NoSuchElement = 'no such element';
    case NoSuchFrame = 'no such frame';
    case NoSuchWindow = 'no such window';
    case NoSuchShadowRoot = 'no such shadow root';
    case ScriptTimeout = 'script timeout';
    case SessionNotCreated = 'session not created';
    case StaleElementReference = 'stale element reference';
    case DetachedShadowRoot = 'detached shadow root';
    case Timeout = 'timeout';
    case UnableToSetCookie = 'unable to set cookie';
    case UnableToCaptureScreen = 'unable to capture screen';
    case UnexpectedAlertOpen = 'unexpected alert open';
    case UnknownCommand = 'unknown command';
    case UnknownError = 'unknown error';
    case UnknownMethod = 'unknown method';
    case UnsupportedOperation = 'unsupported operation';
}
