<?php
class Tabla{
    private $matriz = array();
    private $numFilas;
    private $numColumnas;
    private $estilo;

    public function __construct($row,$cols, $styles){
        $this->numPilas=$row;
        $this->numcolumnas=$cols;
        $this->estilo=$styles;
    }

    public function cargar($row, $col, $val){
        $this->matriz[$row][$col]=$val;
    }

    private function incio_tabla(){
        echo '<table styles="'.$this->estilo.'">';
    }
    private function inicio_fila(){
        echo '<tr>';
    }

    private function mostrar_dato($row,$col){
        echo '<td style="'.$this->estilo.'">';
        echo $this->matriz[$row][$col];
        echo '</td>';
    }
    private function fin_fila(){
        echo '</tr>';
    }

    private function fin_tabla(){
        echo '</table>';
    } 

    public function graficar(){
        $this->incio_tabla();
        for($i=0;$i<$this->numFilas; $i++){
            for($j=0;$j<$this->numColumnas;$j++){
                $this->mostrar_dato($i,$j);
            }
        }
        $this->fin_tabla();
    }

}

?>