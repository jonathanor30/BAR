<!DOCTYPE html>
<html>

<head>
    <meta name='viewport' content='width=device-width'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <style>
        .responsive {
            width: 100%;
            height: auto;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            color: #858796;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .35rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .btn-sm {
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .btn-primary {
            color: #fff !important;
            background-color: #25477B;
            border-color: #25477B;
        }

        .btn-warning {
            color: #fff !important;
            background-color: #f6c23e;
            border-color: #f6c23e;
        }

        a {
            color: #fff !important;
            text-decoration: none;
        }

    </style>
</head>

<body>
    <hr>
    <table>
        <tbody>
            <tr>
                <td colspan="2" style='background-color: #ffffff;'>
                    <div style='color: #2C3E50; font-family: sans-serif'>
                        <h5 style='color: #052d4b; margin: 0 0 7px'>Esta es una notificación de una nueva
                            <?php echo e($documento); ?> generada.</h5><br>
                        <p><strong>En los adjuntos encontraŕa el pdf y el archivo xml.</strong></p>
                    </div>
                </td>
            </tr>
            <?php if(in_array($factura->estadodian2, [null, ''])): ?>
                <tr>
                    <td style='background-color: #ffffff; text-align:center'>
                        <a target="_blank" href="<?php echo e($rutaA); ?>" class="btn btn-sm btn-primary">Aceptar</button>
                    </td>
                    <td style='background-color: #ffffff; text-align:center'>
                        <a target="_blank" href="<?php echo e($rutaR); ?>" class="btn btn-sm btn-warning">Rechazar</button>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div style='font-size: 15px;  margin: 10px 0; color:red; text-align: center'></div>
    <p style='color: #22222; font-size: 10px; text-align: center;margin: 30px 0 0; font-family: sans-serif;'>Generado,
        firmado y enviado por <strong><?php echo e($APP_NAME); ?></strong><br>Negocio, reescrito por software</p>
</body>

</html>
<?php /**PATH /home/transpor/gtep.transportesonix.com/app/Plugins/Facturacion/Views/email/email.blade.php ENDPATH**/ ?>