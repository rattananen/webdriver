<?php

namespace Rattananen\Webdriver\Input;

use Rattananen\Webdriver\Input\InputSources\{Key, Pointer};
use Rattananen\Webdriver\Types\{PointerType, PointerButton};
use Rattananen\Webdriver\Element;
use Rattananen\Webdriver\Math\Vec2;

/**
 * @final
 */
class InputBuilder
{
    private function __construct()
    {
    }

    /**
     * @return Pointer[]
     */
    public static function createPinch(Element|Vec2 $to, int $radius, int $innerRadius = 5, int $degree = -45): array
    {
        $rad = deg2rad($degree);

        $dragTo = match (get_class($to)) {
            Element::class => function (float $rad) use ($to, $radius, $innerRadius): Pointer {
                $cos = cos($rad);
                $sin = sin($rad);
                $p = new Pointer(null, PointerType::touch);
                $p
                    ->move($radius * $cos, $radius * $sin, $to)
                    ->down()
                    ->move($innerRadius * $cos, $innerRadius * $sin, $to)
                    ->up();
                return $p;
            },
            Vec2::class =>  function (float $rad) use ($to, $radius, $innerRadius): Pointer {
                $cos = cos($rad);
                $sin = sin($rad);
                $p = new Pointer(null, PointerType::touch);
                $p
                    ->move($radius * $cos + $to->x, $radius * $sin + $to->y)
                    ->down()
                    ->move($innerRadius * $cos + $to->x, $innerRadius * $sin + $to->y)
                    ->up();
                return $p;
            }
        };

        return [$dragTo($rad), $dragTo($rad + M_PI)];
    }

    /**
     * @return Pointer[]
     */
    public static function createZoom(Element|Vec2 $from, int $radius, int $innerRadius = 5, int $degree = -45): array
    {
        $rad = deg2rad($degree);
        $dragFrom = match (get_class($from)) {
            Element::class => function (float $rad) use ($from, $radius, $innerRadius): Pointer {
                $cos = cos($rad);
                $sin = sin($rad);
                $p = new Pointer(null, PointerType::touch);
                $p
                    ->move($innerRadius * $cos, $innerRadius * $sin, $from)
                    ->down()
                    ->move($radius * $cos, $radius * $sin, $from)
                    ->up();
                return $p;
            },
            Vec2::class => function (float $rad) use ($from, $radius, $innerRadius): Pointer {
                $cos = cos($rad);
                $sin = sin($rad);
                $p = new Pointer(null, PointerType::touch);
                $p
                    ->move($innerRadius * $cos + $from->x, $innerRadius * $sin +  $from->y)
                    ->down()
                    ->move($radius * $cos + $from->x, $radius * $sin +  $from->y)
                    ->up();
                return $p;
            }
        };
        return [$dragFrom($rad), $dragFrom($rad + M_PI)];
    }

    public static function createDrag(
        Vec2|Element $from,
        Vec2|Element $to,
        PointerType $type = PointerType::mouse,
        PointerButton $btn = PointerButton::primary
    ): Pointer {
        $p = new Pointer(null, $type);
        if ($from instanceof Vec2) {
            $p->move($from->x, $from->y);
        } else {
            $p->move(0, 0, $from);
        }

        $p->down($btn);

        if ($to instanceof Vec2) {
            $p->move($to->x, $to->y);
        } else {
            $p->move(0, 0, $to);
        }

        return $p->up($btn);
    }

    /**
     * @param string[] $keys
     * 
     * @return \Rattananen\Webdriver\Input\InputSourceInterface[]
     */
    public static function createHoldAndClick(
        array $keys,
        Vec2|Element $on,
        PointerType $type = PointerType::mouse,
        PointerButton $btn = PointerButton::primary
    ): array {

        $actions = [];
        foreach ($keys as $key) {
            $ka = new Key();
            $ka
                ->keyDown($key)
                ->pause()
                ->keyUp($key);
            $actions[] = $ka;
        }

        $p = new Pointer(null, $type);

        if ($on instanceof Vec2) {
            $p->move($on->x, $on->y);
        } else {
            $p->move(0, 0, $on);
        }
        $p->click($btn);

        $actions[] = $p;

        return $actions;
    }
}
