<?php
declare(strict_types=1);
use App\Application\Repository\CertificationRepository;
use PHPUnit\Framework\TestCase;
use App\Application\Exceptions\CertificationNotFoundException;

/**
 * @uses CertificationRepository 
 * (optional)@covers CertificationRepository::__construct
 */
final class InSqlCertificationRepositoryTest extends TestCase
{
    private $db;
    protected $mockData;
    private $repoCertificado;

    protected function setUp(): void
    {
        $host = 'mariadb';
        $dbname = 'db_asonap';
        $username = 'root';
        $password = 'qwerty';

        // Establecer la conexión a la base de datos
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $this->db = new \PDO($dsn, $username, $password);
        $this->repoCertificado = new CertificationRepository($this->db);
        $this->mockData = [
            array(
                "id" => "2cb8b1ad-15c0-11ee-9544-0242ac150002",
                0 => "2cb8b1ad-15c0-11ee-9544-0242ac150002",
                "documento_identidad" => "111111",
                1 => "111111",
                "cod_asistente" => "FFADSD",
                2 => "FFADSD",
                "nombre_completo" => "David Jose Castillo Cirilo",
                3 => "David Jose Castillo Cirilo",
                "tipo_participacion" => "Conferensista",
                4 => "Conferensista",
                "timestamp" => "2023-06-28 15:36:16",
                5 => "2023-06-28 15:36:16",
                "evento_id" => 1,
                6 => 1
            ),
            array(
                "id" => "2e180f3b-15c3-11ee-9544-0242ac150002",
                0 => "2e180f3b-15c3-11ee-9544-0242ac150002",
                "documento_identidad" => "222222",
                1 => "222222",
                "cod_asistente" => "2023CON05022",
                2 => "2023CON05022",
                "nombre_completo" => "Josue Salomon Castillo Cirilo",
                3 => "Josue Salomon Castillo Cirilo",
                "tipo_participacion" => "Asistente",
                4 => "Asistente",
                "timestamp" => "2023-06-28 15:57:47",
                5 => "2023-06-28 15:57:47",
                "evento_id" => 1,
                6 => 1
            ),
            array(
                "id" => "8168ff5a-15c4-11ee-9544-0242ac150002",
                0 => "8168ff5a-15c4-11ee-9544-0242ac150002",
                "documento_identidad" => "333333",
                1 => "333333",
                "cod_asistente" => "2023CON05021",
                2 => "2023CON05021",
                "nombre_completo" => "Shirly Patricia Vizcaño Pacheco",
                3 => "Shirly Patricia Vizcaño Pacheco",
                "tipo_participacion" => "Asistente",
                4 => "Asistente",
                "timestamp" => "2023-06-28 16:07:16",
                5 => "2023-06-28 16:07:16",
                "evento_id" => 1,
                6 => 1
            )
        ];
    }


    public function testGetCerts(): void
    {

        //$this->assertCount(3, $repoCertificado->getCerts());
        $this->assertEquals($this->mockData, $this->repoCertificado->getCerts());
    }

    public function testGetCertId()
    {
        $this->assertEquals($this->mockData[0]["id"], $this->repoCertificado->checkAndGetCert($this->mockData[0]["id"])->getId());
    }
    public function testGetCertificationNotFoundException()
    {
        $this->expectException(CertificationNotFoundException::class);
        $this->repoCertificado->checkAndGetCert("id_no_existente");
    }

    protected function tearDown(): void
    {
        // Cerrar la conexión a la base de datos
        $this->db = null;
    }
}