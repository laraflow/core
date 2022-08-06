<?php

namespace Laraflow\Core\Http\Response;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Laraflow\Core\Exceptions\XmlResponseException;
use ReflectionClass;
use ReflectionException;
use SimpleXMLElement;

/**
 * Class XmlResponse
 */
class XmlResponse
{
    /**
     * @var bool
     */
    private $caseSensitive = false;

    /**
     * @var string
     */
    private $template = '<root></root>';

    /**
     * @var bool
     */
    private $showEmptyField = true;

    /**
     * @var string
     */
    private $charset = 'utf-8';

    /**
     * @var mixed
     */
    private $rowName = null;

    /**
     * @var bool
     */
    private $asXml = false;

    /**
     * XmlResponse constructor.
     */
    public function __construct()
    {
        $this->config(Config::get('core.xml'));
    }

    /**
     * replaces the current setting
     *
     * @param  array  $config
     * @return void
     */
    private function config($config = [])
    {
        foreach ($config as $key => $value) {
            if ($this->isConfig($key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @param $value
     * @return bool
     */
    private function isConfig($value): bool
    {
        return in_array($value, [
            'template',
            'caseSensitive',
            'showEmptyField',
            'charset',
            'rowName',
        ]);
    }

    /**
     * @param  array  $array
     * @param  array  $config
     * @return string
     *
     * @throws XmlResponseException
     * @throws ReflectionException
     */
    public function asXml($array = [], $config = []): string
    {
        $this->asXml = true;

        return $this->array2xml($array, false, $config);
    }

    /**
     * @param $array
     * @param  bool  $xml
     * @param  array  $config
     * @param  int  $status
     * @return mixed
     *
     * @throws XmlResponseException
     * @throws ReflectionException
     */
    public function array2xml($array, $xml = false, $config = [], $status = 200)
    {
        if (is_object($array) && $array instanceof Arrayable) {
            $array = $array->toArray();
        }

        if (! $this->isType(gettype($array))) {
            throw new XmlResponseException('It is not possible to convert data to XML Response');
        }

        $this->config($config);

        if ($xml === false) {
            $this->encodingXml();
            $xml = new SimpleXMLElement($this->template);
        }

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $this->array2xml($value, $xml->addChild($this->caseSensitive($this->rowName($key))));
                } else {
                    $this->array2xml($value, $xml->addChild($this->caseSensitive($key)));
                }
            } elseif (is_object($value)) {
                $this->array2xml($value, $xml->addChild($this->caseSensitive((new ReflectionClass(get_class($value)))->getShortName())));
            } else {
                if (! is_null($value) || $this->showEmptyField) {
                    if (is_numeric($key)) {
                        $xml->addChild($this->caseSensitive($this->rowName($key)), htmlspecialchars($value));
                    } else {
                        $xml->addChild($this->caseSensitive($key), htmlspecialchars($value));
                    }
                }
            }
        }

        if ($this->asXml) {
            return $xml->asXML();
        }

        return Response::make($xml->asXML(), $status, $this->header());
    }

    /**
     * @param  string  $value
     * @return bool
     */
    private function isType(string $value): bool
    {
        return in_array($value, [
            'model',
            'collection',
            'array',
            'object',
        ]);
    }

    /**
     * add encoding
     */
    private function encodingXml()
    {
        if (! empty($this->charset) && strpos($this->template, 'encoding') === false) {
            $this->template = "<?xml version=\"1.0\" encoding=\"{$this->charset}\"?>{$this->template}";
        }
    }

    /**
     * @param $value
     * @return mixed
     */
    private function caseSensitive($value)
    {
        if ($this->caseSensitive) {
            $value = explode('_', $value);
            $value = lcfirst(implode('', array_map('ucfirst', $value)));
        }

        return $value;
    }

    private function rowName($row)
    {
        if (! empty($this->rowName)) {
            return $this->rowName;
        }

        return 'row_'.$row;
    }

    /**
     * @return mixed
     */
    private function header()
    {
        return [
            'Content-Type' => $this->charset(),
        ];
    }

    /**
     * @param  array  $header
     * @return string
     */
    private function charset($header = []): string
    {
        $charset = 'application/xml; ';

        if (! empty($this->charset)) {
            $charset .= "charset={$this->charset}";
        }

        return $charset;
    }
}
