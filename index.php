<?php


abstract class Animal
{
    protected $registrationNumber;
    public static $countEat = 0;
    public static $count = 0;

    abstract function collect(): int;

    public function __construct()
    {
        static::$count++;
    }

    public static function getCount()
    {
        return self::$count;
    }

    public function produce(): void
    {
        static::$countEat += $this->collect();

        $this->collect();
    }
}

class Cow extends Animal
{
    public static $countEat = 0;
    public static $count = 0;

    public function collect(): int
    {
        return rand(0, 5); // Генерация случайного количества молока
    }
}

class Chicken extends Animal
{
    public static $countEat = 0;
    public static $count = 0;

    public function collect(): int
    {
        return rand(0, 5); // Генерация случайного количества яиц
    }
}

class Farm
{
    private static $instance;
    private $animals = [];

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Farm();
        }
        return self::$instance;
    }

    public function addAnimal(Animal $animal)
    {
        $this->animals[get_class($animal)] = $animal;
    }

    public function printAnimals()
    {
        foreach ($this->animals as $animal) {
            var_dump(get_class($animal) . " " . ($animal)::$count);
        }
    }

    public function collectProducts()
    {
        foreach ($this->animals as $animal) {
            $animal->produce();
        }
    }

    public function printProducts()
    {
        foreach ($this->animals as $animal) {
            $classAnimal = get_class($animal);
            $countEat = ($animal)::$countEat;

            var_dump("у $classAnimal есть $countEat продуктов");
        }
    }
}

// Инициализация фермы
$farm = Farm::getInstance();


for ($i = 0; $i < 10; $i++) {
    $farm->addAnimal(new Cow());
}
for ($i = 0; $i < 20; $i++) {
    $farm->addAnimal(new Chicken());
}

$farm->printAnimals();

for ($i = 0; $i < 7; $i++) {
    $farm->collectProducts();
}

$farm->printProducts();

for ($i = 0; $i < 5; $i++) {
    $farm->addAnimal(new Chicken());
}

$farm->addAnimal(new Cow());

$farm->printAnimals();


for ($i = 0; $i < 7; $i++) {
    $farm->collectProducts();
}

$farm->printProducts();

// for ($i = 0; $i < 5; $i++) {
//     $farm->addAnimal(new Chicken());
// }
// $farm->addAnimal(new Cow());

// $farm->printAnimals();

// for ($i = 0; $i < 7; $i++) {
//     $farm->collectProducts();
// }