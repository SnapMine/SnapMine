<?php

namespace Nirbose\PhpMcServ\Block;

use BackedEnum;
use Exception;
use Nirbose\PhpMcServ\Material;

class BlockStateLoader
{
    private array $blocksData;

    /**
     * @throws Exception
     */
    public function __construct(string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception("The file blocks.json could not be found at: {$filePath}");
        }

        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);

        if ($data === null) {
            throw new Exception("The file blocks.json is malformed or empty.");
        }

        $this->blocksData = $data;
    }

    public function hasBlock(string $blockName): bool
    {
        return isset($this->blocksData[$blockName]);
    }

    public function getBlockData(string $blockName): array
    {
        if ($this->hasBlock($blockName)) {
            return $this->blocksData[$blockName];
        }

        return [];
    }

    public function getBlockStateId(string|Material $blockName, array $propertyValues): int
    {
        if (is_string($blockName)) {
            $baseId = constant(Material::class . "::" . strtoupper(str_replace("minecraft:", "", $blockName)))->getBlockId();
        } else {
            $baseId = $blockName->getBlockId();
            $blockName = $blockName->getKey();
        }

        $blockData = $this->getBlockData($blockName);

        if (!isset($blockData['coefficients']))
            return $baseId;

        $coefficients = $blockData['coefficients'];
        $properties = $blockData['properties'];

        ksort($properties);
        ksort($propertyValues);

        if (empty($properties) || empty($propertyValues)) {
            return $baseId;
        }

        $offset = 0;
        $propertyNames = array_keys($properties);

        for ($i = 0; $i < count($propertyNames); $i++) {
            $propertyName = $propertyNames[$i];

            if (!isset($propertyValues[$propertyName])) {
                throw new Exception("Property '{$propertyName}' is missing in the provided property values for block {$blockName}.");
            }
            $propertyValue = $propertyValues[$propertyName];


            if (is_bool($propertyValue)) {
                $propertyValue = $propertyValue ? 'true' : 'false';
            } else if ($propertyValue instanceof BackedEnum) {
                $propertyValue = $propertyValue->value;
            }

            $validValues = $properties[$propertyName];
            $index = array_search($propertyValue, $validValues, true);

            $offset += $index * $coefficients[$i];
        }

        return $baseId + $offset;
    }
}