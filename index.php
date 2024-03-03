<?php


//Реализация продукта для животного
interface Product
{
    public function getProduce();
}

class CowProduct implements Product
{
    public function getProduce(): int
    {
        return rand(0, 5);
    }
}

class ChickenProduct implements Product
{
    public function getProduce(): int
    {
        return rand(0, 5);
    }
}

abstract class Animal
{
    protected $registrationNumber;
    public static $countEat = 0;
    public static $count = 0;
    private $product;

    // abstract function collect(): int;

    public function __construct(Product $product)
    {
        static::$count++;

        $this->product = $product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public static function getCount()
    {
        return self::$count;
    }

    public function produce(): void
    {
        $produce = $this->product->getProduce();

        static::$countEat += $produce;
    }
}

class Cow extends Animal
{
    public static $countEat = 0;
    public static $count = 0;
}

class Chicken extends Animal
{
    public static $countEat = 0;
    public static $count = 0;
}

class Farm
{
    private static $instance;
    private $animals = [];

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

// Добавление уникального продукта
for ($i = 0; $i < 10; $i++) {
    $farm->addAnimal(new Cow(new CowProduct()));
}
for ($i = 0; $i < 20; $i++) {
    $farm->addAnimal(new Chicken(new ChickenProduct()));
}
// Вывод всех животных
$farm->printAnimals();

// Собирание продуктов
for ($i = 0; $i < 7; $i++) {
    $farm->collectProducts();
}

// Вывод продуктов
$farm->printProducts();

for ($i = 0; $i < 5; $i++) {
    $farm->addAnimal(new Chicken(new ChickenProduct()));
}

$farm->addAnimal(new Cow(new CowProduct()));

$farm->printAnimals();


for ($i = 0; $i < 7; $i++) {
    $farm->collectProducts();
}

$farm->printProducts();
