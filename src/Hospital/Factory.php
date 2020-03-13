<?php

namespace Hospital;
class Factory {
    public function his(){
        return new His(config('services.his.url'));
    }

    public function pay(){
        return new Pay(config('services.pay.url'));
    }
}