<?php

namespace Modules\Core\Block;

interface BlockInterface
{
    public function __construct($block_route_item );
    public function renderFront();

    public function renderAdmin();
    public function saveConfig();
}
