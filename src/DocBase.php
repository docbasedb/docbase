<?php

namespace DocBase;

use DocBase\Exceptions\Exceptions;

class DocBase
{
    private string $dbPath;

    public function __construct(string $dbPath)
    {
        $this->dbPath = rtrim($dbPath, '/');
        if (!is_dir($this->dbPath)) {
            if (!mkdir($this->dbPath, 0777, true)) {
                throw new Exceptions("Failed to create database directory: $this->dbPath");
            }
        }
    }

    public function createCollection(string $collectionName): void
    {
        $filePath = $this->getCollectionPath($collectionName);
        if (file_exists($filePath)) {
            throw new Exceptions("Collection '$collectionName' already exists.");
        }
        file_put_contents($filePath, json_encode([]));
    }

    public function insert(string $collectionName, array $document): void
    {
        $data = $this->getCollectionData($collectionName);
        $data[] = $document;
        $this->saveCollectionData($collectionName, $data);
    }

    public function find(string $collectionName, array $query = []): array
    {
        $data = $this->getCollectionData($collectionName);
        return array_values(array_filter($data, function ($item) use ($query) {
            foreach ($query as $key => $value) {
                if (!isset($item[$key]) || $item[$key] != $value) {
                    return false;
                }
            }
            return true;
        }));
    }

    public function update(string $collectionName, array $query, array $updates): void
    {
        $data = $this->getCollectionData($collectionName);
        foreach ($data as &$item) {
            $match = true;
            foreach ($query as $key => $value) {
                if (!isset($item[$key]) || $item[$key] != $value) {
                    $match = false;
                    break;
                }
            }
            if ($match) {
                $item = array_merge($item, $updates);
            }
        }
        $this->saveCollectionData($collectionName, $data);
    }

    public function delete(string $collectionName, array $query): void
    {
        $data = $this->getCollectionData($collectionName);
        $data = array_filter($data, function ($item) use ($query) {
            foreach ($query as $key => $value) {
                if (isset($item[$key]) && $item[$key] == $value) {
                    return false;
                }
            }
            return true;
        });
        $this->saveCollectionData($collectionName, array_values($data));
    }

    private function getCollectionPath(string $collectionName): string
    {
        return "{$this->dbPath}/$collectionName.json";
    }

    private function getCollectionData(string $collectionName): array
    {
        $filePath = $this->getCollectionPath($collectionName);
        if (!file_exists($filePath)) {
            throw new Exceptions("Collection '$collectionName' does not exist.");
        }
        return json_decode(file_get_contents($filePath), true) ?: [];
    }

    private function saveCollectionData(string $collectionName, array $data): void
    {
        $filePath = $this->getCollectionPath($collectionName);
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
    }
}
