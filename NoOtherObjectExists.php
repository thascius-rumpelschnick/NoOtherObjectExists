<?php

namespace DataCollectionApplication\Validator;


use DataCollectionApplication\Entity\Website;
use DoctrineModule\Validator\NoObjectExists;

/**
 * Class NoOtherObjectExists
 *
 * @inheritdoc
 * @package DataCollectionApplication\Validator
 */
class NoOtherObjectExists extends NoObjectExists
{
    /**
     * @inheritdoc
     * @param mixed $value
     * @return bool
     * @throws \Exception
     */
    public function isValid($value)
    {
        $property = $this->getOption('property');

        if (!array_key_exists('name', $property)) {
            throw new \Exception('Must be set in class DataCollectionApplication\Form\WebsiteForm : options => property => name !');
        }
        if (!array_key_exists('value', $property)) {
            throw new \Exception('Must be set in class DataCollectionApplication\Form\WebsiteForm : options => property => value !');
        }

        $propertyName = $property['name'];
        $propertyValue = $property['value'];

        $getterMethod = 'get' . ucfirst($propertyName);

        $cleanedValue = $this->cleanSearchValue($value);
        $matches = $this->objectRepository->findBy($cleanedValue);


        if ($matches) {

            foreach ($matches as $index => $match) {

                if (!method_exists($match, $getterMethod)) {
                    throw new \Exception(sprintf('Method %s() doesn\'t exist in class %s!', $getterMethod, Website::class));
                }

                if ((is_object($match) && ($match->$getterMethod()) != $propertyValue)) {
                    $this->error(self::ERROR_OBJECT_FOUND, $value);

                    return false;
                }
            }
        }

        return true;
    }
}
