<?php

namespace His;
class Isp {
    public function his(){
        return new His(config('services.his.url'));
    }

    public function pay(){
        return new Pay(config('services.pay.url'));
    }
}