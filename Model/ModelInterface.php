<?php

namespace Model;

interface ModelInterface
{

    public function __construct();

    public function getEditable();

    public function getRequired();
}
