<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Core\Jose\Jwa;

use IdentityLayer\Core\Jose\AlgorithmName;
use IdentityLayer\Core\Jose\Jwa\RS;
use ParagonIE\ConstantTime\Base64UrlSafe;
use PHPUnit\Framework\TestCase;

class RSTest extends TestCase
{
    private string $privateKeyPem;

    public function setUp(): void
    {
        $this->privateKeyPem = '-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEA4glElShvjGLQG+XNlhp6pa9/x71knoNCWrGRzQmBGDFPsG+g
YcXLbsBJgwvdQ05TMywlUVOjam9EvbXL2cIKjCuwyi65kNwqIYTXmj7fJdR5zTCN
YQCtMbeiGf8qu3f5ubljYNzX7Nwt03nLwi5elspioy1rhYvW7nS24gPyYYkHJ1v2
2hk63NIiGaJk1DSKh5ZlIWj3aS3sI8RrC11uI0sM6uInDAJzkouU7eQhumYqTHdD
kzZFrPLasdF+u0CmsApJpfe27Go32EfLkPMlCvLE4hCOI70sJvmWARNEHPIEZxyN
ruv0WvunRP7HVjnFNQ7Mb5t+wC+WD+oKrVq44wIDAQABAoIBAQDMCd+t4TVofV4s
gLGnOLnTzGtFS5KDgCsqoTXi5xxwUTsFIo6dE6ZCkDMLp28RLafu/n+lPSG7lztv
IKcmJ4HL7DiHGcyKliM15KuW4gAfLwDQF27XzHuK8J/UZcEWPwPfAhlSO6hyeIKp
bj1fSOo7pe+KKxrvDz9yO0tHFJb8MLobwfQqaonMx/KQx5CH2tUNKt8ztcTuY/C4
omrq+szsc37ds/RxMst0LMA3Y7alnSZnTW0z+epCaqWzbwsk3WOG+AVojk6VIP8W
6zEnrnP5WsBXI4y41Cb3sJ4rDhs5fHeo9LfVZ3sOTz0voxBf6/NiNC6FE6YJ08eb
zXk2mYfJAoGBAPeG9mebD6ZxdJR/gXjem6+XutTSvA33Uk3yBCVTgS/EngArlPK4
A1AjHqhBnWZG04MIej4bY8nEh25Tg3urvSapJHT1GOPe1GS497CCFYNP2Xj66Wws
/9WlXM8y834AAln6OASn+33dS22WBUBdKJwewSV70nJo4mkHnD2WwLr3AoGBAOnF
+8qfx8GFjRiNtEzfSuGyO4z9ddx71lV0M2gwG/E1UWVQTnr3dc3BIhGdXD5BnWTK
qN/ZUhC+oqpW77ixEDFOnc4lPwzroomUcZGMoMhPTDr6sPIKm1xU4NvjqPY0ThiM
rfkVIsmg3Sh4TnxI1MV67JDJYHpdjQhE8la7PWp1AoGBALcgjJAeMjfr3Fo48yrf
VsNUOA9YUXTrs2KjWNncq8kRZ+usUqg354uUUAwfbznJ0JYy4W2tiegulBvVgYMv
jeNaY/R7mIyNwQk7p1RZCV165+QPjj5QFH6VttI8WdSwYQz8iBE5zmBSJonO4de6
lF7cif0XXJz0Z/1Yegk+zRwFAoGAY+Q5p2eHD+ZlWCyU8pQnhzGFyMU1a7Vu7Kzu
moKULgm+cjBSmLDNIdJ5IFXBaMjY3IzMhHp0Wrta/raPULg4VxlkzQWVX4wAtBE+
Rhd1TKK1zC37FjH6GQYb31n0hN/szwit/lVNvCKE3hoqT2k/ofLYyzWBiEgZT4NG
mlD/+VECgYAWJibo+YYngFPK90Mv4/vKlDD66JG97cnTQkl6YiNIlYyEhwGxRXcW
UWyqtp06tHJpOCb6E7Ut4SDmEvMobTaQSygu61nXOLMHpJEBwSejYJL8DEksUfqz
/zrnd0e1HxxV00WktoWzmmp+SWd5hSo0VTzHILYoKxRxkofMiOlmFQ==
-----END RSA PRIVATE KEY-----';
    }

    public function testSigning(): void
    {
        $rs256 = RS::fromPrivateKeyPemEncoded($this->privateKeyPem, AlgorithmName::RS256());
        $message256 = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0';
        $rs256Signature = Base64UrlSafe::decode('TwBPtu-ib2TtocrNSVEwRAQG7ooAkCTILmklEY5TyNk94sSh2ORYCie_pFJABEJ1N3Omk7NezY5i609p7fXySmtrOZBorxakfYMlPIujo38k2MiQSyHDWM4DL4faum9DVKsLMl7Ok0BS2MuZ0YsZGLzCzExU_BsNLkPNmSTf6wSO-Fv3xvIxz4Kw7APyFcjVK3mEHb2TA-1u36W43DU4ylCc70MK1MrdrqIUYcOFJLvNYye9CNIbCmogj2ls5DLGSLlX2HPLQrjEs1gUYK81Eqr1LRttIgEC0UpLbdB5za4llocNcCxKetgsEHY4fEiZ9I5P3T7N1IRzChhxJX5rPA');

        $this->assertEquals($rs256Signature, $rs256->sign($message256));

        $rs384 = RS::fromPrivateKeyPemEncoded($this->privateKeyPem, AlgorithmName::RS384());
        $message384 = 'eyJhbGciOiJSUzM4NCIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0';
        $rs384Signature = Base64UrlSafe::decode('dqgtcIKyk7_UuYd72C-OX2M2YfsWCtUaktZ8jJNS-U4sSMjwM-JXme78MbG3JCheYr49Y86AVi83jK-yr7sQd4JC_lovMi31HJ_o0EZMNFT4mO4Ho-8lKQfnVZLpprO-roT7_B1UAIS_ZrdFfSCf2atxs62iz_c3qLjnjk_3YnzxHpHebS2M_boOLGBWeeQDZuuvOIL1z2NUdiTUg4Bh6_G5ZvZOjI3UL57nNt4O1MUJkI_pb3fZAPzV9Z9YQbi1W9cQP9Z7j0X5RcYUWQJAagN7Qengc0CJNkLIatW7sbkDuLoHoEKhThn91NQbGpfPa-cp46Ab7avImd8g0odMAQ');

        $this->assertEquals($rs384Signature, $rs384->sign($message384));

        $rs512 = RS::fromPrivateKeyPemEncoded($this->privateKeyPem, AlgorithmName::RS512());
        $message512 = 'eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0';
        $rs512Signature = Base64UrlSafe::decode('nY0Zh7PXLjvi3G0wq-hP7vYGCG5RKXRfJqYyeubWbkdBdcp6LkHYD7BlrOa9HrCVyVgB4bv2AHb8rjDZYC-YjJU9DceJFAjzpcsTeDWcKqgvB9LDRKGqizRv0phUFVCBlyaqWpcBkWBM7iyVvox3iYgpree1ky9wcM3wAQQYLt_9Ud9Rr45Xyd9pA5Mp_P6UIHAzx9pPT93uB6Gx3Ticc1PQaHBbVPJkMHxPmmlJMAvE1RC8CG5Rvqj7K4CW7GTKopfub_lnk1uG3w1_YYy0LSzheC-RIgt7pBE4mAAd3H_P3TVxrcaldkSxc6VrYOKE9KdtlZBrWLKCeIhkCui3sA');

        $this->assertEquals($rs512Signature, $rs512->sign($message512));
    }
}