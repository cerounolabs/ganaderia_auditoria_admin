<?php
    function getUUID(){
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); 
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); 
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    function getOT(){
        $result = date("Ymdhisv");
        return $result;
    }

    function getColorPositivoNegativo($nro){
        $result = '';

        if ($nro == 0) {
            $result = '#3e5569';
        }

        if ($nro > 0) {
            $result = '#1ca58f';
        }

        if ($nro < 0) {
            $result = '#eb4c4c';
        }
        return $result;
    }

    function getCantSeccion($dataJSON01, $dataJSON02){
        $result = array();

        if ($dataJSON01['code'] == 200) {
            foreach ($dataJSON01['data'] as $seccionKey=>$seccionArray) {
                $row_seccion_00 = $seccionArray['seccion_codigo'];
                $row_seccion_01 = $seccionArray['seccion_nombre'];
    
                if ($dataJSON02['code'] == 200) {
                    $totalAnimal = 0;
            
                    foreach ($dataJSON02['data'] as $auditadaKey=>$auditadaArray) {
                        $row_auditada_00  = $auditadaArray['seccion_codigo'];
                        $row_auditada_01  = $auditadaArray['ot_auditada_cantidad'];
                        if ($row_auditada_00 == $row_seccion_00) {
                            $totalAnimal = $totalAnimal + $row_auditada_01;
                        }
                    }
                }
    
                if ($totalAnimal > 0) {
                    $detalle    = array('id' => $row_seccion_00, 'name' => $row_seccion_01, 'value' => $totalAnimal);
                    $result[]   = $detalle;
                }
            }
        }

        return $result;
    }

    function getCantSeccionCategoria($dataJSON01, $dataJSON02, $dataJSON03){
        $result = array();

        if ($dataJSON01['code'] == 200) {
            foreach ($dataJSON01['data'] as $seccionKey=>$seccionArray) {
                $row_seccion_00 = $seccionArray['seccion_codigo'];
                $row_seccion_01 = $seccionArray['seccion_nombre'];

                if ($dataJSON02['code'] == 200) {
                    foreach ($dataJSON02['data'] as $dominioKey=>$dominioArray) {
                        $row_dominio_00 = $dominioArray['dominio_codigo'];
                        $row_dominio_01 = $dominioArray['dominio_nombre'];
                        $row_dominio_02 = $dominioArray['dominio_valor'];

                        if ($row_dominio_02 == 'ANIMALCATEGORIA') {
                            if ($dataJSON03['code'] == 200) {
                                $totalAnimal = 0;
                    
                                foreach ($dataJSON03['data'] as $auditadaKey=>$auditadaArray) {
                                    $row_auditada_00  = $auditadaArray['seccion_codigo'];
                                    $row_auditada_01  = $auditadaArray['categoria_codigo'];
                                    $row_auditada_02  = $auditadaArray['categoria_nombre'];
                                    $row_auditada_03  = $auditadaArray['ot_auditada_cantidad'];

                                    if (($row_auditada_00 == $row_seccion_00) && ($row_auditada_01 == $row_dominio_00)) {
                                        $totalAnimal = $totalAnimal + $row_auditada_03;
                                    }
                                }
                            }

                            if ($totalAnimal > 0) {
                                $detalle    = array('id' => $row_seccion_00, 'id2' => $row_dominio_00, 'name' => $row_dominio_01, 'value' => $totalAnimal);
                                $result[]   = $detalle;
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }

    function getCantSeccionSubCategoria($dataJSON01, $dataJSON02, $dataJSON03, $dataJSON04){
        $result = array();

        if ($dataJSON01['code'] == 200) {
            foreach ($dataJSON01['data'] as $seccionKey=>$seccionArray) {
                $row_seccion_00 = $seccionArray['seccion_codigo'];
                $row_seccion_01 = $seccionArray['seccion_nombre'];

                if ($dataJSON02['code'] == 200) {
                    foreach ($dataJSON02['data'] as $dominioKey=>$dominioArray) {
                        $row_dominio_00 = $dominioArray['dominio_codigo'];
                        $row_dominio_01 = $dominioArray['dominio_nombre'];
                        $row_dominio_02 = $dominioArray['dominio_valor'];

                        if ($row_dominio_02 == 'ANIMALCATEGORIA') {
                            if ($dataJSON03['code'] == 200) {
                                foreach ($dataJSON03['data'] as $subdominioKey=>$subdominioArray) {
                                    $row_subdominio_00 = $subdominioArray['dominio_codigo'];
                                    $row_subdominio_01 = $subdominioArray['dominio_nombre'];
                                    $row_subdominio_02 = $subdominioArray['dominio_valor'];

                                    if ($row_subdominio_02 == 'ANIMALSUBCATEGORIA') {
                                        if ($dataJSON04['code'] == 200) {
                                            $totalAnimal = 0;
                                
                                            foreach ($dataJSON04['data'] as $auditadaKey=>$auditadaArray) {
                                                $row_auditada_00  = $auditadaArray['seccion_codigo'];
                                                $row_auditada_01  = $auditadaArray['categoria_codigo'];
                                                $row_auditada_02  = $auditadaArray['categoria_nombre'];
                                                $row_auditada_03  = $auditadaArray['subcategoria_codigo'];
                                                $row_auditada_04  = $auditadaArray['subcategoria_nombre'];
                                                $row_auditada_05  = $auditadaArray['ot_auditada_cantidad'];

                                                if (($row_auditada_00 == $row_seccion_00) && ($row_auditada_01 == $row_dominio_00) && ($row_auditada_03 == $row_subdominio_00)) {
                                                    $totalAnimal = $totalAnimal + $row_auditada_05;
                                                }
                                            }
                                        }

                                        if ($totalAnimal > 0) {
                                            $detalle    = array('id' => $row_seccion_00, 'id2' => $row_dominio_00, 'name' => $row_subdominio_01, 'value' => $totalAnimal);
                                            $result[]   = $detalle;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }

    function getCantPotrero($dataJSON01, $dataJSON02){
        $result = array();

        if ($dataJSON01['code'] == 200) {
            $charTitulo     = '';
            $charCantidad   = '';
            $charBandera    = 0;

            foreach ($dataJSON01['data'] as $potreroKey=>$potreroArray) {
                $row_potrero_00 = $potreroArray['potrero_codigo'];
                $row_potrero_01 = $potreroArray['potrero_nombre'];
    
                if ($dataJSON02['code'] == 200) {
                    $totalAnimal = 0;
            
                    foreach ($dataJSON02['data'] as $auditadaKey=>$auditadaArray) {
                        $row_auditada_00  = $auditadaArray['potrero_codigo'];
                        $row_auditada_01  = $auditadaArray['ot_auditada_cantidad'];
                        if ($row_auditada_00 == $row_potrero_00) {
                            $totalAnimal = $totalAnimal + $row_auditada_01;
                        }
                    }
                }
    
                if ($totalAnimal > 0) {
                    if ($charBandera == 0) {
                        $charBandera    = 1;
                        $charTitulo     = '"'.$row_potrero_01.'"';
                        $charCantidad   = $totalAnimal;
                    } else {
                        $charTitulo     = $charTitulo.', "'.$row_potrero_01.'"';
                        $charCantidad   = $charCantidad.', '.$totalAnimal;
                    }
                }
            }
        }

        $result = array($charTitulo, $charCantidad);

        return $result;
    }

    function getCantDiaTrabajo($dataJSON01){
        $result = array();

        if ($dataJSON01['code'] == 200) {
            $charTitulo     = '';
            $charCantidad   = '';
            $charBandera    = 0;

            foreach ($dataJSON01['data'] as $potreroKey=>$potreroArray) {
                $row_potrero_00 = $potreroArray['ot_auditada_titulo_2'];
                $row_potrero_01 = $potreroArray['ot_auditada_cantidad'];
                
                if ($charBandera == 0) {
                    $charBandera    = 1;
                    $charTitulo     = '"'.$row_potrero_00.'"';
                    $charCantidad   = $row_potrero_01;
                } else {
                    $charTitulo     = $charTitulo.', "'.$row_potrero_00.'"';
                    $charCantidad   = $charCantidad.', '.$row_potrero_01;
                }
            }
        }

        $result = array($charTitulo, $charCantidad);

        return $result;
    }

    function getCantCategoria($dataJSON01, $dataJSON02, $dataJSON03){
        $result = array();

        if ($dataJSON01['code'] == 200) {
            $charTitulo     = '';
            $charCantExi    = '';
            $charCantAud    = '';
            $charBandera    = 0;
            $totalExistencia= 0;
            $totalAuditada  = 0;

            foreach ($dataJSON01['data'] as $dominioKey=>$dominioArray) {
                $row_dominio_00 = $dominioArray['tipo_codigo'];
                $row_dominio_01 = $dominioArray['subtipo_codigo'];
                $row_dominio_02 = $dominioArray['tipo_nombre'];
                $row_dominio_03 = $dominioArray['subtipo_nombre'];
                $charTitulo01   = $row_dominio_02;
    
                if ($dataJSON02['code'] == 200) {
                    $totalExistencia = 0;
            
                    foreach ($dataJSON02['data'] as $existenciaKey=>$existenciaArray) {
                        $row_existencia_00  = $existenciaArray['categoria_codigo'];
                        $row_existencia_01  = $existenciaArray['subcategoria_codigo'];
                        $row_existencia_02  = $existenciaArray['categoria_nombre'];
                        $row_existencia_03  = $existenciaArray['subcategoria_nombre'];
                        $row_existencia_04  = $existenciaArray['ot_existencia_cantidad'];

                        if (($row_existencia_00 == $row_dominio_00)) {
                            $totalExistencia= $totalExistencia + $row_existencia_04;
                        }
                    }
                }

                if ($dataJSON03['code'] == 200) {
                    $totalAuditada = 0;
            
                    foreach ($dataJSON03['data'] as $auditadaKey=>$auditadaArray) {
                        $row_auditada_00  = $auditadaArray['categoria_codigo'];
                        $row_auditada_01  = $auditadaArray['subcategoria_codigo'];
                        $row_auditada_02  = $auditadaArray['categoria_nombre'];
                        $row_auditada_03  = $auditadaArray['subcategoria_nombre'];
                        $row_auditada_04  = $auditadaArray['ot_auditada_cantidad'];
                        
                        if (($row_auditada_00 == $row_dominio_00)) {
                            $totalAuditada = $totalAuditada + $row_auditada_04;
                        }
                    }
                }

                if ($totalExistencia > 0 || $totalAuditada > 0) {
                    if ($charBandera == 0) {
                        $charBandera    = 1;
                        $charTitulo     = '"'.$charTitulo01.'"';
                        $charCantExi    = $totalExistencia;
                        $charCantAud    = $totalAuditada;
                    } else {
                        $charTitulo     = $charTitulo.', "'.$charTitulo01.'"';
                        $charCantExi    = $charCantExi.', '.$totalExistencia;
                        $charCantAud    = $charCantAud.', '.$totalAuditada;
                    }
                }
            }
        }

        $result = array($charTitulo, $charCantExi, $charCantAud);

        return $result;
    }

    function getCantSubCategoria($dataJSON01, $dataJSON02, $dataJSON03){
        $result = array();

        if ($dataJSON01['code'] == 200) {
            $charTitulo     = '';
            $charCantExi    = '';
            $charCantAud    = '';
            $charBandera    = 0;
            $totalExistencia= 0;
            $totalAuditada  = 0;

            foreach ($dataJSON01['data'] as $dominioKey=>$dominioArray) {
                $row_dominio_00 = $dominioArray['tipo_codigo'];
                $row_dominio_01 = $dominioArray['subtipo_codigo'];
                $row_dominio_02 = $dominioArray['tipo_nombre'];
                $row_dominio_03 = $dominioArray['subtipo_nombre'];
                $charTitulo01   = $row_dominio_02.' - '.$row_dominio_03;
    
                if ($dataJSON02['code'] == 200) {
                    $totalExistencia = 0;
            
                    foreach ($dataJSON02['data'] as $existenciaKey=>$existenciaArray) {
                        $row_existencia_00  = $existenciaArray['categoria_codigo'];
                        $row_existencia_01  = $existenciaArray['subcategoria_codigo'];
                        $row_existencia_02  = $existenciaArray['categoria_nombre'];
                        $row_existencia_03  = $existenciaArray['subcategoria_nombre'];
                        $row_existencia_04  = $existenciaArray['ot_existencia_cantidad'];

                        if (($row_existencia_00 == $row_dominio_00) && ($row_existencia_01 == $row_dominio_01)) {
                            $totalExistencia= $totalExistencia + $row_existencia_04;
                        }
                    }
                }

                if ($dataJSON03['code'] == 200) {
                    $totalAuditada = 0;
            
                    foreach ($dataJSON03['data'] as $auditadaKey=>$auditadaArray) {
                        $row_auditada_00  = $auditadaArray['categoria_codigo'];
                        $row_auditada_01  = $auditadaArray['subcategoria_codigo'];
                        $row_auditada_02  = $auditadaArray['categoria_nombre'];
                        $row_auditada_03  = $auditadaArray['subcategoria_nombre'];
                        $row_auditada_04  = $auditadaArray['ot_auditada_cantidad'];
                        
                        if (($row_auditada_00 == $row_dominio_00) && ($row_auditada_01 == $row_dominio_01)) {
                            $totalAuditada = $totalAuditada + $row_auditada_04;
                        }
                    }
                }

                if ($totalExistencia > 0 || $totalAuditada > 0) {
                    if ($charBandera == 0) {
                        $charBandera    = 1;
                        $charTitulo     = '"'.$charTitulo01.'"';
                        $charCantExi    = $totalExistencia;
                        $charCantAud    = $totalAuditada;
                    } else {
                        $charTitulo     = $charTitulo.', "'.$charTitulo01.'"';
                        $charCantExi    = $charCantExi.', '.$totalExistencia;
                        $charCantAud    = $charCantAud.', '.$totalAuditada;
                    }
                }
            }
        }

        $result = array($charTitulo, $charCantExi, $charCantAud);

        return $result;
    }
?>