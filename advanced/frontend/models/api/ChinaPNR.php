<?php
/**
 * Created by IntelliJ IDEA.
 * Author: al
 * Date: 6/24/2014
 * Time: 2:55 AM
 */

namespace frontend\models\api;


class ChinaPNR {
    const VERSION10 = 10;
    const VERSION20 = 20;

    const CMD_DEPOSIT = 'NetSave';

    const PARAM_VERSION = 'Version';
    const PARAM_CMDID = 'CmdId';
    const PARAM_MERCUSTID = 'MerCustId';
    const PARAM_USRCUSTID = 'UsrCustId';
    const PARAM_ORDID = 'OrdId';
    const PARAM_ORDDATE = 'OrdDate';
    const PARAM_GATEBUSIID = 'GateBusiId';
    const PARAM_OPENBANKID = 'OpenBankId';
    const PARAM_DCFLAG = 'DcFlag';
    const PARAM_TRANSAMT = 'TransAmt';
    const PARAM_RETURL = 'RetUrl';
    const PARAM_BGRETURL = 'BgRetUrl';
    const PARAM_MERPRIV = 'MerPriv';
    const PARAM_CHKVALUE = 'ChkValue';

    const RESP_CODE = 'RespCode';
    const RESP_DESC = 'RespDesc';
    const RESP_TRXID = 'TrxId';

    protected $host;
    private $merId;
    protected $params;
    protected $response;
    private $link;
    private $queryString;
    private $maps;
    private $vSignOrder;

    public function __construct()
    {
        $this->host = 'https://lab.chinapnr.com/muser/publicRequests';
        $this->merId = '830068';
        $this->params = [
            self::PARAM_VERSION => self::VERSION10,
            self::PARAM_MERCUSTID => '6000060001283917',
        ];
        $this->link = null;
        $this->queryString = null;
        $this->maps = [
            self::PARAM_VERSION,self::PARAM_CMDID,self::PARAM_MERCUSTID,
            self::PARAM_USRCUSTID,self::PARAM_ORDID,self::PARAM_ORDDATE,
            self::PARAM_GATEBUSIID,self::PARAM_OPENBANKID,self::PARAM_DCFLAG,
            self::PARAM_TRANSAMT,self::PARAM_RETURL,self::PARAM_BGRETURL,
            self::PARAM_MERPRIV,self::PARAM_CHKVALUE,
        ];
        $this->vSignOrder = [
            self::CMD_DEPOSIT => [
                0=>self::PARAM_CMDID,1=>self::RESP_CODE,2=>self::PARAM_MERCUSTID,
                3=>self::PARAM_USRCUSTID,4=>self::PARAM_ORDID,5=>self::PARAM_ORDDATE,
                6=>self::PARAM_TRANSAMT,7=>self::RESP_TRXID,8=>self::PARAM_RETURL,
                9=>self::PARAM_BGRETURL,10=>self::PARAM_MERPRIV
            ],
        ];
    }

    public function deposit()
    {
        $this->params[self::PARAM_CMDID] = self::CMD_DEPOSIT;
        return $this;
    }

    public function setResponse(array $responseArr)
    {
        $cmdId = isset($responseArr[self::PARAM_CMDID]) && $responseArr[self::PARAM_CMDID] ? $responseArr[self::PARAM_CMDID] : null;
        $chkValue = isset($responseArr[self::PARAM_CHKVALUE]) && $responseArr[self::PARAM_CHKVALUE] ? $responseArr[self::PARAM_CHKVALUE] : null;
        if ($cmdId && $chkValue)
        {
            $vSignFieldsOrd = isset($this->vSignOrder[$cmdId]) ? $this->vSignOrder[$cmdId] : null;
            if ($vSignFieldsOrd)
            {
                //Check Sign
                $vSignMessage = '';
                for($i=0;$i<count($vSignFieldsOrd);$i++)
                {
                    $field = $vSignFieldsOrd[$i];
                    $value = isset($responseArr[$field]) && $responseArr[$field] ? trim($responseArr[$field]) : null;
                    if ($value) $vSignMessage .= $value;
                }
                if ($this->_vSign($vSignMessage, $chkValue))
                {
                    foreach($responseArr as $k => $v)
                    {
                        if ($k == self::RESP_DESC) $v = urldecode($v);
                        if ($k == self::PARAM_MERPRIV) $v = base64_decode($v);
                        $this->response[$k] = $v;
                    }
                }
                else exit(验签失败);
            }
        }
        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getLink()
    {
        if (!$this->link)
        {
            $this->sign();
            $this->link = $this->host.($this->queryString ? $this->queryString : '');
        }
        return $this->link;
    }

    public function __get($name)
    {
        $value = null;
        $params = [];
        foreach($this->params as $k=>$v)
            $params[strtolower($k)] = $v;
        if (isset($params[strtolower($name)]) && $params[strtolower($name)]) $value = $params[strtolower($name)];
        else $value = $this->$name;
        return $value;
    }

    public function __set($name, $value)
    {
        $name = strtolower($name);
        foreach($this->maps as $field)
            if ($name == strtolower($field)) $this->params[$field] = $value;
        return $this;
    }

    private function sign()
    {
        $signMessage = null;
        $chkValue = null;
        switch ($this->params[self::PARAM_CMDID])
        {
            case self::CMD_DEPOSIT:
                $signOrd = [
                    0=>self::PARAM_VERSION, 1=>self::PARAM_CMDID, 2=>self::PARAM_MERCUSTID,
                    3=>self::PARAM_USRCUSTID,4=>self::PARAM_ORDID,5=>self::PARAM_ORDDATE,
                    6=>self::PARAM_GATEBUSIID,7=>self::PARAM_OPENBANKID,8=>self::PARAM_DCFLAG,
                    9=>self::PARAM_TRANSAMT,10=>self::PARAM_RETURL,11=>self::PARAM_BGRETURL,
                    12=>self::PARAM_MERPRIV
                ];
                $vSignOrd = [
                    self::PARAM_CMDID,self::RESP_CODE,self::PARAM_MERCUSTID,
                    self::PARAM_USRCUSTID,self::PARAM_ORDID,self::PARAM_ORDDATE,
                    self::PARAM_TRANSAMT,self::RESP_TRXID,self::PARAM_RETURL,
                    self::PARAM_BGRETURL,self::PARAM_MERPRIV
                ];
                $signMessage = $this->_getSignMessageStr($signOrd);
                break;
        }
        if ($signMessage) $chkValue = $this->_sign($signMessage);
        if ($chkValue)
        {
            $this->queryString .= '&'.self::PARAM_CHKVALUE.'='.$chkValue;
            $this->params[self::PARAM_CHKVALUE] = $chkValue;
        }
        return $this;
    }

    private function _sign($msg)
    {
        $sign = null;
        $fp = fsockopen("115.28.152.140", 8866, $errno, $errstr, 10);
        if ($fp)
        {
            $len = sprintf("%04s", strlen($msg));
            $out = 'S'.$this->merId.$len.$msg;
            $out = sprintf("%04s", strlen($out)).$out;
            fputs($fp, $out);
            while(!feof($fp)) $sign .= fgets($fp, 128);
            fclose($fp);
            $sign = substr($sign, -256);
        }
        return $sign;
    }

    private function _vSign($messageBody, $chkValue)
    {
        $result = false;
        $len = sprintf("%04s", strlen($messageBody));
        $out = 'V'.$this->merId.$len.$messageBody.$chkValue;
        $out = sprintf("%04s", strlen($out)).$out;
        $fp = fsockopen("115.28.152.140", 8866, $errno, $errstr, 10);
        if ($fp)
        {
            fputs($fp, $out);
            $in = '';
            while(!feof($fp)) $in .= fgets($fp, 128);
            fclose($fp);
            $result = substr($in, -4) == '0000';
        }
        return $result;
    }

    private function _getSignMessageStr(array $signParamOrd)
    {
        $message = '';
        for($i=0; $i<count($signParamOrd);$i++)
        {
            $name = $signParamOrd[$i];
            $val = isset($this->params[$name]) ? trim($this->params[$name]) : null;
            if ($val)
            {
                if ($name == self::PARAM_MERPRIV) $val = base64_encode($val);
                $message .= $val;
                if ($name == self::PARAM_RETURL || $name == self::PARAM_BGRETURL) $val = urlencode($val);
                $this->queryString .= $this->queryString ? '&'.$name.'='.$val : '?'.$name.'='.$val;
            }
        }

        return $message;
    }
}