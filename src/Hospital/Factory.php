<?php

namespace Hospital;

class Factory {
    public function his($url = ''){
        return new His($url);
    }

    public function pay($url = ''){
        return new Pay($url);
    }
}