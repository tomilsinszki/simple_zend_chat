<?php

namespace Chat\Data;

interface MessageFormattedDataInterface
{
    public function getContent();
    public function getCreatedAtString();
}