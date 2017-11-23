<?php

namespace Teebot\Api\Method;

interface MethodInterface
{
    /**
     * Constructs extended method's class and sets properties from array if passed.
     *
     * @param array $args
     */
    public function __construct(array $args = []);

    /**
     * Returns method's name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns entity's name that should be return in method execution result.
     *
     * @return null|string
     */
    public function getReturnEntity(): ?string;

    /**
     * Returns flag which indicates that method has attached data (audio, voice, video, photo etc.)
     *
     * @return bool
     */
    public function hasAttachedData(): bool;

    /**
     * Returns parent entity which triggered method's execution.
     *
     * @return MethodInterface
     */
    public function getParent(): MethodInterface;

    /**
     * Sets parent entity which triggered method's execution.
     *
     * @param MethodInterface $parent
     *
     * @return MethodInterface
     */
    public function setParent(MethodInterface $parent): MethodInterface;
}
