<?php

namespace App\Contracts;

interface QrCodeService {
    public function generateQrCode(mixed $data = null): mixed;
}
