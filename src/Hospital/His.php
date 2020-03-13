<?php
namespace Hospital;
// his系统提供的接口

class His extends BaseClient{
    protected $format;
    public function  __construct(string $format = 'json')
    {
        $this->format = $format;
    }

    /**
     * 3.12	预约登记接口(适用于普遍情况)(缺少接口)
     * 患者通过外部预约系统的“自助终端/网络”进行预约，外部预约系统生成相应的订单，同时外部预约系统调用HIS的接口将订单信息同步到HIS。
     */
    public function  addOrder(array $params){
        $url = $this->url.'/addOrder';

        $requestBody = array_filter([
            'Req.LoginName' => $params['LoginName'],
            'Req.loginPwd' => $params['loginPwd'],
            'Req.hospitalId' => $params['hospitalId'],
            'Req.orderType' => $params['orderType'],
            'Req.orderId' => $params['orderId'],
            'Req.deptId' => $params['deptId'],
            'Req.doctorId' => $params['doctorId'],
            'Req.regDate' => $params['regDate'],
            'Req.timeID' => $params['timeID'],
            'Req.timfFlag' => $params['timfFlag'],
            'Req.startTime' => $params['startTime'],
            'Req.endTime' => $params['endTime'],
            'Req.regType' => $params['regType'],
            'Req.userHISPatientID' => $params['userHISPatientID'],
            'Req.userIdCard' => $params['userIdCard'],
            'Req.userJKK' => $params['userJKK'],
            'Req.userSMK' => $params['userSMK'],
            'Req.userYBK' => $params['userYBK'],
            'Req.userYLZ' => $params['userYLZ'],
            'Req.userAddress' => $params['userAddress'],
            'Req.userName' => $params['userName'],
            'Req.userGender' => $params['userGender'],
            'Req.userMobile' => $params['userMobile'],
            'Req.userBirthday' => $params['userBirthday'],
            'Req.userType' => $params['userType'],
            'Req.operIdCard' => $params['operIdCard'],
            'Req.operName' => $params['operName'],
            'Req.operMobile' => $params['operMobile'],
            'Req.userChoice' => $params['userChoice'],
            'Req.orderTime' => $params['orderTime'],
            'Req.fee' => $params['fee'],
            'Req.treatfee' => $params['treatfee'],
            'Req.RegisterFlag' => $params['RegisterFlag'],
        ]);

        $response = $this->getHttpClient()->post($url, [
            $requestBody,
        ])->getBody()->getContents();

        return 'json' === $this->format ? \json_decode($response, true) : $response;
    }

    /**
     * 在患者通过外部诊疗系统退订时，外部诊疗系统调用HIS的该接口。（此种情况适用于已提交预约订单但未支付的情况）。
    外部诊疗系统对于过期未支付的订单可调用此接口进行自动取消预约，以免占用医院号源。

     */
    public function cancelOrder(array $params){
        $url = $this->url.'/cancelOrder';
        $requestParams = array_filter(array(
            'req.orderType' => $params['orderType'],//-4-医院窗口          	8-医生诊间挂号	6-自助机	52-云医院APP	62-微信公众号	63-支付宝服务窗	204-手机APP	205-医院官网
            'req.Provider' => $params['Provider'],//	0-医院	9-广州市集约平台	37-中行	52-云医院APP	99-北大医信	100-倍康	102-医享网
            'req.orderId' => $params['orderId'],//外部诊疗系统的订单号
            'req.cancelTime' => $params['cancelTime'], //取消时间，格式：YYYY-MM-DD HH24:MI:SS
            'req.cancelReason' => $params['cancelReason'],//取消原因
        ));
        $response = $this->getHttpClient()->post($url,$requestParams);
        return 'json' === $this->format ? \json_decode($response, true) : $response;
    }

    /**
     * 3.14	挂号支付接口
     * 患者通过外部诊疗系统支付时，外部诊疗系统调用HIS的该接口，将支付结果同步到HIS（支付仅限30分钟内提交的订单）。
     * @param array $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function payOrder(array $params){
        $url = $this->url .'/payOrder';
        $requestParams = array_filter(array([
            'req.orderType' => $params['orderType'],
            'req.Provider' => $params['Provider'],
            'req.orderId' => $params['orderId'],
            'req.orderIDHIS' => $params['orderIDHIS'],
            'req.payMode' => $params['payMode'],
            'req.PayOrderType' => $params['PayOrderType'],
            'req.PayProvider' => $params['PayProvider'],
            'req.payNum' => $params['payNum'],
            'req.payAmout' => $params['payAmout'],
            'req.payTime' => $params['payTime'],
            'req.payDesc' => $params['payDesc'],
            'req.EmployeeID' => $params['EmployeeID'],
        ]));
        $response = $this->getHttpClient()->post($url,$requestParams);
        return 'json' === $this->format ? \json_decode($response, true) : $response;
    }

    /**
     * 3.15	挂号退费接口
     * 患者通过外部诊疗系统进行退费时，预约系统调用HIS的该接口将退费信息同步到医院HIS。
     * @param array $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function returnPay(array $params){
        $url = $this->url .'/returnPay';
        $requestParams = array_filter(array([
            'req.orderType' => $params['orderType'],
            'req.Provider' => $params['Provider'],
            'req.orderId' => $params['orderId'],
            'req.returnNum' => $params['returnNum'],
            'req.payMode' => $params['payMode'],
            'req.returnAmout' => $params['returnAmout'],
            'req.returnTime' => $params['returnTime'],
            'req.returnDesc' => $params['returnDesc'],
            'req.returnTypeFlag' => $params['returnTypeFlag'],
            'req.EmployeeID' => $params['EmployeeID'],
        ]));
        $response = $this->getHttpClient()->post($url,$requestParams);
        return 'json' === $this->format ? \json_decode($response, true) : $response;
    }

    /**
     * 3.16	是否成功缴费查询接口(缺少接口)
     * @param array $params
     * @param string $format
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function IssuccessPay(array  $params, $format = 'xml'){
        $url = $this->url .'/IssuccessPay';
        $requestParams = array_filter(array([
            'req.payType' => $params['payType'],
            'req.orderIDHIS' => $params['orderIDHIS'],
            'req.OrderId' => $params['OrderId'],

        ]));
        $response = $this->getHttpClient()->post($url,$requestParams);
        return 'json' === $this->format ? \json_decode($response, true) : $response;
    }
}