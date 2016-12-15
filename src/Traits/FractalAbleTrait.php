<?php

namespace Joselfonseca\LaravelApiTools\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Joselfonseca\LaravelApiTools\Exceptions\UnTransformableResourceException;

/**
 * Class FractalAbleTrait
 * @package Joselfonseca\LaravelApiTools\Traits
 */
trait FractalAbleTrait
{


    /**
     * Sets the serializer to be used in the transformation
     * @return SerializerAbstract
     */
    public function setSerializer()
    {
        return app(DataArraySerializer::class);
    }


    /**
     * Transforms a collection into an array using the transformer specified
     * @param Collection $collection
     * @param null $resourceKey
     * @param array $meta
     * @return array
     */
    public function transformCollection(Collection $collection, $resourceKey = null, $meta = [])
    {
        $resource =  fractal()
            ->collection($collection, $this->setTransformer(), $resourceKey)
            ->serializeWith($this->setSerializer());
        if(count($meta) > 0){
            $resource->addMeta($meta);
        }
        return $resource->toArray();
    }


    /**
     * Transforms a model into an array using the transformer specified
     * @param Model $item
     * @param null $resourceKey
     * @param array $meta
     * @return array
     */
    public function transformItem(Model $item, $resourceKey = null, $meta = [])
    {
        $resource =  fractal()
            ->item($item, $this->setTransformer(), $resourceKey)
            ->serializeWith($this->setSerializer());
        if(count($meta) > 0){
            $resource->addMeta($meta);
        }
        return $resource->toArray();
    }


    /**
     * Transforms a collection with pagination into an array using the transformer specified
     * @param LengthAwarePaginator $paginator
     * @param null $resourceKey
     * @param array $meta
     * @return array
     */
    public function transformPaginator(LengthAwarePaginator $paginator, $resourceKey = null, $meta = [])
    {
        $resource = fractal()
            ->collection($paginator->getCollection(), $this->setTransformer(), $resourceKey)
            ->serializeWith($this->setSerializer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator));
        if(count($meta) > 0){
            $resource->addMeta($meta);
        }
        return $resource->toArray();
    }


    /**
     * Applies transformation to the entity, collection or paginator.
     * @param $resource
     * @param array $meta
     * @return array
     * @throws UnTransformableResourceException
     */
    public function transform($resource, $meta = [])
    {
        if ($resource instanceof Model) {
            return $this->transformItem($resource, $this->resourceKey, $meta);
        }

        if ($resource instanceof Collection) {
            return $this->transformCollection($resource, $this->resourceKey, $meta);
        }

        if ($resource instanceof LengthAwarePaginator) {
            return $this->transformPaginator($resource, $this->resourceKey, $meta);
        }
        throw new UnTransformableResourceException;
    }
}
