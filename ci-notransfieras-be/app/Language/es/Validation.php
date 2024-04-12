<?php

// override core en language system validation or define your own en language validation message
return [
      // Reglas de validación personalizadas
      'required'      => 'El campo {field} es obligatorio.',
      'is_unique'     => 'El valor del campo {field} ya existe en la base de datos.',
      'valid_email'  => 'El campo {field} debe contener una dirección de correo electrónico válida.',
      'min_length' => 'El campo {field} debe tener al menos {param} caracteres de longitud.',
      'max_length' => 'El campo {field} no puede exceder los {param} caracteres de longitud.',
      'validateUser' => 'Credenciales no validas.',
      // Añade más mensajes según tus necesidades
];