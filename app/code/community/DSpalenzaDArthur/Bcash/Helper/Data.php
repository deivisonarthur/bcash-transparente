<?php
/**
 * Módulo Bcash Free 
 *
 * @category   Payments
 * @package    DSpalenzaDArthur_Bcash
 * @license    OSL v3.0
 * @author	   Denis Spalenza e Deivison Arthur
 */
class DSpalenzaDArthur_Bcash_Helper_Data extends Mage_Core_Helper_Abstract {
    
    /**
     * Converte ID do pedido
     * 
     * @param string
     * @return string
     */
    public function convertOrderId($OrderId) {
        $orderStr = (string)$OrderId;
        $tam = strlen($orderStr);
        
        for($i=0;$i<8-$tam;$i++) {
            $orderStr = '0'.$orderStr;
        }
        $orderStr = '1'.$orderStr;
        
        return $orderStr;
    }
    
    /**
     * Converte código padrão dos países de 2 digítos para 3 digítos.
     * 
     * @param string
     * @return string
     */
    public function convertCodeCountry($code) {
        switch($code) {
            case 'AA': return 'AAA';
            case 'AD': return 'AND';
            case 'AE': return 'ARE';
            case 'AF': return 'AFG';
            case 'AG': return 'ATG';
            case 'AI': return 'AIA';
            case 'AL': return 'ALB';
            case 'AM': return 'ARM';
            case 'AN': return 'ANT';
            case 'AO': return 'AGO';
            case 'AQ': return 'ATA';
            case 'AR': return 'ARG';
            case 'AS': return 'ASM';
            case 'AT': return 'AUT';
            case 'AU': return 'AUS';
            case 'AW': return 'ABW';
            case 'AX': return 'ALA';
            case 'AZ': return 'AZE';
            case 'BA': return 'BIH';
            case 'BB': return 'BRB';
            case 'BD': return 'BGD';
            case 'BE': return 'BEL';
            case 'BF': return 'BFA';
            case 'BG': return 'BGR';
            case 'BH': return 'BHR';
            case 'BI': return 'BDI';
            case 'BJ': return 'BEN';
            case 'BL': return 'BLM';
            case 'BM': return 'BMU';
            case 'BN': return 'BRN';
            case 'BO': return 'BOL';
            case 'BR': return 'BRA';
            case 'BS': return 'BHS';
            case 'BT': return 'BTN';
            case 'BU': return 'BUR';
            case 'BV': return 'BVT';
            case 'BW': return 'BWA';
            case 'BY': return 'BLR';
            case 'BZ': return 'BLZ';
            case 'CA': return 'CAN';
            case 'CC': return 'CCK';
            case 'CD': return 'COD';
            case 'CF': return 'CAF';
            case 'CG': return 'COG';
            case 'CH': return 'CHE';
            case 'CI': return 'CIV';
            case 'CK': return 'COK';
            case 'CL': return 'CHL';
            case 'CM': return 'CMR';
            case 'CN': return 'CHN';
            case 'CO': return 'COL';
            case 'CR': return 'CRI';
            case 'CS': return 'SCG';
            case 'CU': return 'CUB';
            case 'CV': return 'CPV';
            case 'CX': return 'CXR';
            case 'CY': return 'CYP';
            case 'CZ': return 'CZE';
            case 'DD': return 'DDR';
            case 'DE': return 'DEU';
            case 'DJ': return 'DJI';
            case 'DK': return 'DNK';
            case 'DM': return 'DMA';
            case 'DO': return 'DOM';
            case 'DZ': return 'DZA';
            case 'EC': return 'ECU';
            case 'EE': return 'EST';
            case 'EG': return 'EGY';
            case 'EH': return 'ESH';
            case 'ER': return 'ERI';
            case 'ES': return 'ESP';
            case 'ET': return 'ETH';
            case 'FI': return 'FIN';
            case 'FJ': return 'FJI';
            case 'FK': return 'FLK';
            case 'FM': return 'FSM';
            case 'FO': return 'FRO';
            case 'FR': return 'FRA';
            case 'FX': return 'FXX';
            case 'GA': return 'GAB';
            case 'GB': return 'GBR';
            case 'GD': return 'GRD';
            case 'GE': return 'GEO';
            case 'GF': return 'GUF';
            case 'GG': return 'GGY';
            case 'GH': return 'GHA';
            case 'GI': return 'GIB';
            case 'GL': return 'GRL';
            case 'GM': return 'GMB';
            case 'GN': return 'GIN';
            case 'GP': return 'GLP';
            case 'GQ': return 'GNQ';
            case 'GR': return 'GRC';
            case 'GS': return 'SGS';
            case 'GT': return 'GTM';
            case 'GU': return 'GUM';
            case 'GW': return 'GNB';
            case 'GY': return 'GUY';
            case 'HK': return 'HKG';
            case 'HM': return 'HMD';
            case 'HN': return 'HND';
            case 'HR': return 'HRV';
            case 'HT': return 'HTI';
            case 'HU': return 'HUN';
            case 'ID': return 'IDN';
            case 'IE': return 'IRL';
            case 'IL': return 'ISR';
            case 'IM': return 'IMN';
            case 'IN': return 'IND';
            case 'IO': return 'IOT';
            case 'IQ': return 'IRQ';
            case 'IR': return 'IRN';
            case 'IS': return 'ISL';
            case 'IT': return 'ITA';
            case 'JE': return 'JEY';
            case 'JM': return 'JAM';
            case 'JO': return 'JOR';
            case 'JP': return 'JPN';
            case 'KE': return 'KEN';
            case 'KG': return 'KGZ';
            case 'KH': return 'KHM';
            case 'KI': return 'KIR';
            case 'KM': return 'COM';
            case 'KN': return 'KNA';
            case 'KP': return 'PRK';
            case 'KR': return 'KOR';
            case 'KW': return 'KWT';
            case 'KY': return 'CYM';
            case 'KZ': return 'KAZ';
            case 'LA': return 'LAO';
            case 'LB': return 'LBN';
            case 'LC': return 'LCA';
            case 'LI': return 'LIE';
            case 'LK': return 'LKA';
            case 'LR': return 'LBR';
            case 'LS': return 'LSO';
            case 'LT': return 'LTU';
            case 'LU': return 'LUX';
            case 'LV': return 'LVA';
            case 'LY': return 'LBY';
            case 'MA': return 'MAR';
            case 'MC': return 'MCO';
            case 'MD': return 'MDA';
            case 'ME': return 'MNE';
            case 'MG': return 'MDG';
            case 'MF': return 'MAF';
            case 'MH': return 'MHL';
            case 'MK': return 'MKD';
            case 'ML': return 'MLI';
            case 'MM': return 'MMR';
            case 'MN': return 'MNG';
            case 'MO': return 'MAC';
            case 'MP': return 'MNP';
            case 'MQ': return 'MTQ';
            case 'MR': return 'MRT';
            case 'MS': return 'MSR';
            case 'MT': return 'MLT';
            case 'MU': return 'MUS';
            case 'MV': return 'MDV';
            case 'MW': return 'MWI';
            case 'MX': return 'MEX';
            case 'MY': return 'MYS';
            case 'MZ': return 'MOZ';
            case 'NA': return 'NAM';
            case 'NC': return 'NCL';
            case 'NE': return 'NER';
            case 'NF': return 'NFK';
            case 'NG': return 'NGA';
            case 'NI': return 'NIC';
            case 'NL': return 'NLD';
            case 'NO': return 'NOR';
            case 'NP': return 'NPL';
            case 'NR': return 'NRU';
            case 'NT': return 'NTZ';
            case 'NU': return 'NIU';
            case 'NZ': return 'NZL';
            case 'OM': return 'OMN';
            case 'PA': return 'PAN';
            case 'PE': return 'PER';
            case 'PF': return 'PYF';
            case 'PG': return 'PNG';
            case 'PH': return 'PHL';
            case 'PK': return 'PAK';
            case 'PL': return 'POL';
            case 'PM': return 'SPM';
            case 'PN': return 'PCN';
            case 'PR': return 'PRI';
            case 'PS': return 'PSE';
            case 'PT': return 'PRT';
            case 'PW': return 'PLW';
            case 'PY': return 'PRY';
            case 'QA': return 'QAT';
            case 'QM': return 'QMM';
            case 'QN': return 'QNN';
            case 'QO': return 'QOO';
            case 'QP': return 'QPP';
            case 'QQ': return 'QQQ';
            case 'QR': return 'QRR';
            case 'QS': return 'QSS';
            case 'QT': return 'QTT';
            case 'QU': return 'QUU';
            case 'QV': return 'QVV';
            case 'QW': return 'QWW';
            case 'QX': return 'QXX';
            case 'QY': return 'QYY';
            case 'QZ': return 'QZZ';
            case 'RE': return 'REU';
            case 'RO': return 'ROU';
            case 'RS': return 'SRB';
            case 'RU': return 'RUS';
            case 'RW': return 'RWA';
            case 'SA': return 'SAU';
            case 'SB': return 'SLB';
            case 'SC': return 'SYC';
            case 'SD': return 'SDN';
            case 'SE': return 'SWE';
            case 'SG': return 'SGP';
            case 'SH': return 'SHN';
            case 'SI': return 'SVN';
            case 'SJ': return 'SJM';
            case 'SK': return 'SVK';
            case 'SL': return 'SLE';
            case 'SM': return 'SMR';
            case 'SN': return 'SEN';
            case 'SO': return 'SOM';
            case 'SR': return 'SUR';
            case 'ST': return 'STP';
            case 'SU': return 'SUN';
            case 'SV': return 'SLV';
            case 'SY': return 'SYR';
            case 'SZ': return 'SWZ';
            case 'TC': return 'TCA';
            case 'TD': return 'TCD';
            case 'TF': return 'ATF';
            case 'TG': return 'TGO';
            case 'TH': return 'THA';
            case 'TJ': return 'TJK';
            case 'TK': return 'TKL';
            case 'TL': return 'TLS';
            case 'TM': return 'TKM';
            case 'TN': return 'TUN';
            case 'TO': return 'TON';
            case 'TP': return 'TMP';
            case 'TR': return 'TUR';
            case 'TT': return 'TTO';
            case 'TV': return 'TUV';
            case 'TW': return 'TWN';
            case 'TZ': return 'TZA';
            case 'UA': return 'UKR';
            case 'UG': return 'UGA';
            case 'UM': return 'UMI';
            case 'US': return 'USA';
            case 'UY': return 'URY';
            case 'UZ': return 'UZB';
            case 'VA': return 'VAT';
            case 'VC': return 'VCT';
            case 'VE': return 'VEN';
            case 'VG': return 'VGB';
            case 'VI': return 'VIR';
            case 'VN': return 'VNM';
            case 'VU': return 'VUT';
            case 'WF': return 'WLF';
            case 'WS': return 'WSM';
            case 'XA': return 'XAA';
            case 'XB': return 'XBB';
            case 'XC': return 'XCC';
            case 'XD': return 'XDD';
            case 'XE': return 'XEE';
            case 'XF': return 'XFF';
            case 'XG': return 'XGG';
            case 'XH': return 'XHH';
            case 'XI': return 'XII';
            case 'XJ': return 'XJJ';
            case 'XK': return 'XKK';
            case 'XL': return 'XLL';
            case 'XM': return 'XMM';
            case 'XN': return 'XNN';
            case 'XO': return 'XOO';
            case 'XP': return 'XPP';
            case 'XQ': return 'XQQ';
            case 'XR': return 'XRR';
            case 'XS': return 'XSS';
            case 'XT': return 'XTT';
            case 'XU': return 'XUU';
            case 'XV': return 'XVV';
            case 'XW': return 'XWW';
            case 'XX': return 'XXX';
            case 'XY': return 'XYY';
            case 'XZ': return 'XZZ';
            case 'YD': return 'YMD';
            case 'YE': return 'YEM';
            case 'YT': return 'MYT';
            case 'YU': return 'YUG';
            case 'ZA': return 'ZAF';
            case 'ZM': return 'ZMB';
            case 'ZR': return 'ZAR';
            case 'ZW': return 'ZWE';
            case 'ZZ': return 'ZZZ';
            default: return 'BRA';
        }
    }
    
    /**
     * Escapa entidades HTML.
     * Função criada para compatibilidade com versões mais antigas do Magento.
     *
     * @param   mixed $data
     * @param   array $allowedTags
     * @return  string
     */
    public function escapeHtml($data, $allowedTags = null)
    {
        $core_helper = Mage::helper('core');
        if (method_exists($core_helper, "escapeHtml")) {
            return $core_helper->escapeHtml($data, $allowedTags);
        } elseif (method_exists($core_helper, "htmlEscape")) {
            return $core_helper->htmlEscape($data, $allowedTags);
        } else {
            return $data;
        }
        
    }
}
