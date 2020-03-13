<?php

namespace Hospital;

class Pay extends BaseClient{

    public $url;
    public function __construct($url)
    {
        parent::__construct();
        $this->url = $url;
    }

    //微信/支付宝付款码支付
    public function pay(array $params, $format = 'json') {
        $url = $this->url.'/hisRequestPayCenter/pay';
        $requestParams = array([
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ],
            'body'=>[
                'req.unionPayKey' => $params['unionPayKey'],// 复合支付秘钥联合支付（带轮转规则，待测试时提供）
                'req.payCode' => $params['payCode'],//  支付码 设备读取用户的条码或二维码，不传会只进行订单状态查询。
                'req.branchCode' => $params['branchCode'],// 院区码
                'req.operatorId' => $params['operatorId'], //操作员码 用于获取显示二维码的设备号
                'req.deviceInfo' => $params['deviceInfo'], // 终端设备号
                'req.orderIdHIS' => $params['orderIdHIS'], // HIS订单号 医院生成的订单号
                'req.hisseq' => $params['hisseq'], // 流水号 门诊： RegisterID 住院：InPatientID
                'req.settlementType' => $params['settlementType'], // 结算方式类型
                'req.payMode' => $params['payMode'], // 支付方式
                'req.payType' => $params['payType'], // 支付方式
                'req.patientCardType' => $params['patientCardType'], // 缴费类型
                'req.patinetJKK' => $params['patinetJKK'], // 诊疗卡号
                'req.patinetID' => $params['patinetID'], // 患者id
                'req.patinetName' => $params['patinetName'], // 患者姓名
                'req.patinetIdNo' => $params['patinetIdNo'], // 身份证号
                'req.patinetMobile' => $params['patinetMobile'], // 手机号码
                'req.payAmout' => $params['payAmout'], // 支付金额
                'req.accountAmout' => $params['accountAmout'], // 个人账户金额
                'req.medicareAmout' => $params['medicareAmout'], // 统筹记账金额
                'req.totalAmount' => $params['totalAmount'], // 总金额
            ]
        ]
        );
        return $this->requestUrl($url, $requestParams, $format);
    }

    // 统一退费接口
    public function refund(array $params, $format = 'json') {
        $url = $this->url.'/hisRequestPayCenter/refund';
        $requestParams = array([
            'req.branchCode' => $params['branchCode'],
            'req.operatorId' => $params['operatorId'],
            'req.deviceInfo' => $params['deviceInfo'],
            'req.orderIdHIS' => $params['orderIdHIS'],
            'req.orderId' => $params['orderId'],
            'req.totalAmount' => $params['totalAmount'],
            'req.refundAmount' => $params['refundAmount'],
            'req.refundType' => $params['refundType'],
            'req.refundReason' => $params['refundReason'],
            'req.refundTag' => $params['refundTag'],
        ]);
        return $this->requestUrl($url, $requestParams, $format);
    }

    // 统一撤销
    public function reverse(array $params, $format = 'json') {
        $url = $this->url.'/hisRequestPayCenter/reverse';
        $requestParams = array([
            'req.branchCode' => $params['branchCode'],
            'req.operatorId' => $params['operatorId'],
            'req.deviceInfo' => $params['deviceInfo'],
            'req.orderIdHIS' => $params['orderIdHIS'],
            'req.orderId' => $params['orderId'],
        ]);
        return $this->requestUrl($url, $requestParams, $format);
    }

    // 统一订单查询
    public function query(array $params, $format = 'json') {
        $url = $this->url.'/hisRequestPayCenter/query';
        $requestParams = array([
            'req.branchCode' => $params['branchCode'],
            'req.orderId' => $params['orderId'],
            'req.orderIdHIS' => $params['orderIdHIS'],
        ]);
        return $this->requestUrl($url, $requestParams, $format);
    }

    // 微信支付宝申请
    public function jcPayOrder(array $params,int $type=1, string $format = 'json') {
        $url = '';
        switch ($type){
            case 1:
                $url = $this->url.'/requestPayCenter/jcPayOrder'; // 挂号缴费
                break;
            case 2:
                $url = $this->url.'/requestPayCenter/jcPayBigOrder';// 门诊缴费
                break;
            case 3:
                $url = $this->url.'/requestPayCenter/jcAddPrepayToPay'; // 按金缴费
                break;
            default:
                $url = $this->url.'/requestPayCenter/jcAddPrepayToPay'; // 按金缴费
                break;
        }
        $requestParams = array([
            'his.orderIDHIS'=> $params['his']['orderIDHIS'],
            'his.payAmount'=> $params['his']['payAmount'],
            'his.payPartialFeeFlag'=> $params['his']['payPartialFeeFlag'],
            'his.selfPayFlag'=> $params['his']['selfPayFlag'],
            'his.hisInPatientID'=> $params['his']['hisInPatientID'],
            'his.employeeNo'=> $params['his']['employeeNo'],
            'isp.paykey'=> $params['isp']['paykey'],
            'isp.payType'=> $params['isp']['payType'],
            'isp.opType'=> $params['isp']['opType'],
            'isp.delegateOrderId'=> $params['isp']['delegateOrderId'],
            'isp.userId'=> $params['isp']['userId'],
            'isp.spbillCreateIp'=> $params['isp']['spbillCreateIp'],
            'isp.returnUrl'=> $params['isp']['returnUrl'],
            'patientInfo.cardType'=> $params['patientInfo']['cardType'],
            'patientInfo.cardNum'=> $params['patientInfo']['cardNum'],
            'patientInfo.userName'=> $params['patientInfo']['userName'],
            'patientInfo.userGender'=> $params['patientInfo']['userGender'],
            'patientInfo.userMobile'=> $params['patientInfo']['userMobile'],
            'patientInfo.userPatientId'=> $params['patientInfo']['userPatientId'],
            'patientInfo.userJkk'=> $params['patientInfo']['userJkk'],
            'patientInfo.userSmk'=> $params['patientInfo']['userSmk'],
            'patientInfo.userYbk'=> $params['patientInfo']['userYbk'],
            'patientInfo.userYlz'=> $params['patientInfo']['userYlz'],
            'randomStr'=> $params['randomStr'],
            'sign'=> $params['sign'],
        ]);
        return $this->requestUrl($url,$requestParams,$format);
    }

    // 微信、支付宝申请回调通知
    public function back() {

    }

    // 微信支付宝退费申请
    public function jcReturnPay(array $params, string $format = 'json') {
        $url = $this->url.'/refund/requestRefundCenter2/jcRequestReturnPay/jcReturnPay'; // 挂号退费
        $requestParams = array([
            'isp.paykey'=> $params['isp']['paykey'],// 支付密钥
            'isp.delegateOrderId'=> $params['isp']['delegateOrderId'], // 委托方订单号
            'isp.orderId'=> $params['isp']['orderId'], // isp生成的订单号
            'randomStr' => $params['randomStr'],
            'sign' => $params['sign'],
        ]);
        return $this->requestUrl($url, $requestParams, $format);
    }

    // 微信支付宝退费申请回调
    public function jcReturnPayBack() {
        return $_REQUEST;
    }

    // 获取医保待缴费信息接口
    public function getPayDetailInfoGZYB(array $params, string $format = 'json') {
        $url = $this->url.'/requestCenter/getPayDetailInfoGZYB';
        $requestParams = array([
            'orderIDHIS' => $params['orderIDHIS'], // HIS就诊登记号
            'PartialFeeFlag' => $params['PartialFeeFlag'], //查询部分费用标志0-查询全部费用1-只查询缴挂号费诊金
            'userYBGRBH' => $params['userYBGRBH'], //医保个人编号（即医保系统中的“个人电脑号”，允许不提供该参数）-门慢医保必填，参考HIS说明文档“广州医保用户待缴费记录查询接口”说明
            'serial_apply' => $params['serial_apply'],// 门慢申请序列号 -门慢医保必填，同上
            'treatment_type' => $params['treatment_type'], //待遇类型 -门慢医保必填，同上
            'icd' => $params['icd'],// 疾病编码 -门慢医保必填，同上
        ]);
        return $this->requestUrl($url, $requestParams, $format);
    }

}