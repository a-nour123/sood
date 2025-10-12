<?php
date_default_timezone_set("UTC");
return [
    'strict' => false,
    'debug' => false,
    #'security' => ['sessionNotOnOrAfter' => 60],
    'sp' => [
        #'entityId' => 'http://10.190.62.71/saml/metadata',
        'entityId' => 'https://grc.ksu.edu.sa/saml/metadata',
        'assertionConsumerService' => [
            #'url' => 'http://10.190.62.71/saml/acs',
            'url' => 'https://grc.ksu.edu.sa/saml/acs',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ],
        'singleLogoutService' => [
            #'url' => 'http://10.190.62.71/cybermode/public/saml/logout',
            #'url' => 'http://10.190.62.71/login',
            'url' => 'https://grc.ksu.edu.sa/logout',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],
        'x509cert' => '',
        'privateKey' => '',
    ],
    'idp' => [
        'entityId' => 'KingSaud-SAML-PROD',
        'singleSignOnService' => [
            'url' => 'https://iam.ksu.edu.sa/idp/SSO.saml2',
            #'url' => 'https://iam.ksu.edu.sa/idp/startSSO.ping',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],
        'singleLogoutService' => [
            #'url' => 'https://grc.ksu.edu.sa/',
            #'url' => 'https://iam.ksu.edu.sa/idp/startSLO.ping?PartnerSpId=https://grc.ksu.edu.sa',
            'url' => 'https://iam.ksu.edu.sa/idp/startSLO.ping',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],
        'x509cert' =>'MIIDBDCCAeygAwIBAgIGAYdBoq4kMA0GCSqGSIb3DQEBCwUAMEMxCzAJBgNVBAYTAlNBMQswCQYDVQQHEwJTQTEMMAoGA1UEChMDS1NVMRkwFwYDVQQDExBQcm9kS1NVU2lnbkNlcnQyMB4XDTIzMDQwMjExMDMxM1oXDTI2MDQwMTExMDMxM1owQzELMAkGA1UEBhMCU0ExCzAJBgNVBAcTAlNBMQwwCgYDVQQKEwNLU1UxGTAXBgNVBAMTEFByb2RLU1VTaWduQ2VydDIwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCje/kDBgF7mlrhY1rkxgQBd0+e+jF9T9R0fcv/B0xXrsgp1clDLKM+2imPNHJvZtp8oDbkdcrtMKAj1GQUSjvhCahX/iywz0xEh37hom1Q6y9BFZWQwHTItrCLncIr9qujwy/4aDr0PJmpjsIIey8FpEVT9EBdpduNpwRVod0WbR+EgnaAG79nf+ZEtNR12k5sLAY3UXBRsJDAsKs9B+Ym/H7b/F77jdLZI4oJSnOVBy8rBpdMOcBesN5jtAtpXJW8DdAMbFIw95wflugnFDy/l4+9j+4qjznzSFJzv/XqlZMr/qeiwY14aBDpYpuxps93s61gJrEWiZY+bnLYVFn/AgMBAAEwDQYJKoZIhvcNAQELBQADggEBAGweln2ELtkXZv5tbJk4DkZ/+BRCJ1cVgqS/IchJSSHSTnbnNxV9K7Z1JGdKurBsRkNUTPuKbDBn0zq3KezrxjP6firvycDaQbTzKaLPL8FHwvvQKg+zKBwfa8aSI/sLPOY/Zo8k5jRmk4HDxMFA3IPlYITl+AjvbJMR0F5fU96C0Zt18iOz2fUasxrEGW9Vlf7ehzsQtO7OqOXtdkvdqWzno2P+iQExwcBureS2WjYxlf+AcK33Sh+uXK6SQlcrmWxiGbDUs930/EGCJCHHVcSdOet6n6eVkNdUAc5On342utJDZT07M/H6sR/6mQWgobwm7QoIffpWcuJHr0dnaFU=',
    ],
];

