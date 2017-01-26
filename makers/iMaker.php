<?php

foreach (glob("../model/*.php") as $filename)
{
    include_once $filename;
}

interface iMaker {
    
    public function create();
    
    public function makeChange();
    
    public function isComplete();
    
    //public function revert();
}