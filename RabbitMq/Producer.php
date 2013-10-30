<?php

namespace OldSound\RabbitMqBundle\RabbitMq;

use OldSound\RabbitMqBundle\RabbitMq\BaseAmqp;
use PhpAmqpLib\Message\AMQPMessage;

class Producer extends BaseAmqp
{
    protected $contentType = 'text/plain';
    protected $deliveryMode = 2;

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    public function setDeliveryMode($deliveryMode)
    {
        $this->deliveryMode = $deliveryMode;

        return $this;
    }

    public function publish($msgBody, $routingKey = null)
    {
        $this->setupFabric();

        $this->getChannel()->basic_publish(
            new AMQPMessage($msgBody, array('content_type' => $this->contentType, 'delivery_mode' => $this->deliveryMode)),
            !empty($this->exchangeOptions['name']) ? $this->exchangeOptions['name'] : '',
            !is_null($routingKey) ? $routingKey : (isset($this->queueOptions['name']) ? $this->queueOptions['name'] : '')
        );
    }
}
