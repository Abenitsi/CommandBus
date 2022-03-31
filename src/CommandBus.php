<?php
namespace Abenitsi\CommandBus;

use Invoker\Exception\InvocationException;
use Invoker\Exception\NotCallableException;
use Invoker\Exception\NotEnoughParametersException;
use Invoker\Invoker;
use Psr\Container\ContainerInterface;

class CommandBus
{
    protected array $handlers;
    protected Invoker $invoker;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->handlers = [];
        $this->invoker = new Invoker(null, $container);
    }

    /**
     * @param String $commandName
     * @param String $handler
     * @return void
     */
    public function addCommand(String $commandName, String $handler)
    {
        $this->handlers[$commandName] = $handler;
    }

    /**
     * @param $command
     * @return false|mixed|void
     * @throws InvocationException
     * @throws NotCallableException
     * @throws NotEnoughParametersException
     */
    public function handle($command)
    {
        return $this->invoker->call([$this->handlers[get_class($command)], 'handle'], [$command]);
    }
}