<?php

namespace  App\Repository;



use RedBeanPHP\OODBBean;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use ReflectionClass;
use ReflectionException;


/**
 * @package App\Repository
 * @template T
 */
abstract class AbstractRepository
{

    /**
     * @var class-string<T>
     */
    protected string $modelClass;

    /**
     * @param class-string<T> $modelClass
     * @param R $db
     */
    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * @param $model
     * @return int|string
     */
    public function save($model): int|string
    {
        try {
            $bean = $this->modelToBean($model);
        } catch (ReflectionException $e) {
        }
        return R::store($bean);
    }

    /**
     * delete model by ID
     * @throws ReflectionException
     * @param int $id
     */
    public function delete(int $id): void
    {
        $bean = R::load($this->getBeanName(), $id);
        R::trash($bean);
    }


    /**
     * @param OODBBean $bean
     * @return T
     */
    protected function beanToModel(OODBBean $bean)
    {
        $model = new $this->modelClass();

        foreach ($bean as $property => $value) {
            if (property_exists($model, $property)) {
                $model->$property = $value;
            }
        }

        return $model;
    }

    /**
     * @throws ReflectionException
     */
    protected function modelToBean($model): array|OODBBean
    {
        $bean = R::dispense($this->getBeanName());

        $reflection = new ReflectionClass($this->modelClass);

        $props = $reflection->getProperties();

        foreach ($props as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            if ($property->getName() === 'id') {
                if ($property->getValue($model)) {
                    $bean->id = $property->getValue($model);
                }
            } else {
                $bean->$propertyName = $property->getValue($model);
            }
        }

        return $bean;
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    protected  function getBeanName(): string
    {
        return strtolower((new ReflectionClass($this->modelClass))->getShortName());
    }

}