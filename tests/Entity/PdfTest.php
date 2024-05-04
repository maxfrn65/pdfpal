<?php

namespace App\Tests\Entity;

use App\Entity\Pdf;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class PdfTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $pdf = new Pdf();
        $user = new User();
        $title = 'titre';
        $datetime = new \DateTimeImmutable();
        $createdAt = $datetime->format('d/m/Y');
        $pdf->setTitle($title);
        $pdf->setCreatedAt($createdAt);
        $pdf->setUser($user);
        $this->assertEquals($title, $pdf->getTitle());
        $this->assertEquals($createdAt, $pdf->getCreatedAt());
        $this->assertEquals($user, $pdf->getUser());
    }
}
