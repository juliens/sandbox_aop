<?php

class UnitOfWork
{
    public function propertyChanged($instance, $field = null, $value = null)
    {

    }
}

function UnitOfWork ($instance, $field = null, $value = null) {

}

class Foo
{
    public $bar;
    public $baz;
}

$n = 50;
$m = 50;

$unitOfWork = new UnitOfWork();

for ($t = 0; $t < 10; $t++) {

    $s = microtime(True);
    for ($i = 0; $i < $n; $i++) {
        $foo = new Foo();
        for ($j = 0; $j < $m; $j++) {
            $foo->bar = "bar";
            $foo->baz = "baz";
            $foo->bar = "bar";
            $foo->baz = "baz";
            #$bar = $foo->bar = $foo->baz;
        }
    }
    $results[0][] = microtime(true) - $s;
}

for ($t = 0; $t < 10; $t++) {
    $s = microtime(True);
    for ($i = 0; $i < $n; $i++) {
        $foo = new Foo();
        for ($j = 0; $j < $m; $j++) {
            $foo->bar = "bar";
            $unitOfWork->propertyChanged($foo, "bar", "bar");
            //call_user_func_array(array ($unitOfWork, 'propertyChanged'), array ($foo, "bar","bar"));
            $foo->baz = "baz";
            //call_user_func_array(array ($unitOfWork, 'propertyChanged'), array ($foo, "baz","baz"));
            $unitOfWork->propertyChanged($foo, "baz", "baz");
            $foo->bar = "bar";
            //call_user_func_array(array ($unitOfWork, 'propertyChanged'), array ($foo, "bar","bar"));
            $unitOfWork->propertyChanged($foo, "bar", "bar");
            $foo->baz = "baz";
            //call_user_func_array(array ($unitOfWork, 'propertyChanged'), array ($foo, "baz","baz"));
            $unitOfWork->propertyChanged($foo, "baz", "baz");
            #$bar = $foo->bar = $foo->baz;
        }
    }
    $results[1][] = microtime(true) - $s;
}

aop_add_after("write Foo::*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));
aop_add_after("write Fo*::other*", array($unitOfWork, 'propertyChanged'));


for ($t = 0; $t < 10; $t++) {
    $s = microtime(True);

    for ($i = 0; $i < $n; $i++) {
        $foo = new Foo();
        for ($j = 0; $j < $m; $j++) {
            $foo->bar = "bar";
            $foo->baz = "baz";
            #$bar = $foo->bar = $foo->baz;
            $foo->bar = "bar";
            $foo->baz = "baz";
        }
    }
    $results[2][] = microtime(true) - $s;
}

$plain                = array_sum($results[0]) / count($results[0]);
$manualChangeTracking = array_sum($results[1]) / count($results[1]);
$aopChangeTracking    = array_sum($results[2]) / count($results[2]);

echo number_format($plain, 4) . "\n";
echo number_format($manualChangeTracking, 4) . " (" . number_format($manualChangeTracking / $plain, 4) . ")\n";
echo number_format($aopChangeTracking, 4) . " (" . number_format($aopChangeTracking / $plain, 4) . ", " . number_format($aopChangeTracking / $manualChangeTracking, 4) . ")\n";
