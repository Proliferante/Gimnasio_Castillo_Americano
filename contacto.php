<?php
$mensaje_enviado = false;
$error_envio = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $asunto = trim($_POST['asunto'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if ($nombre && $email && $mensaje) {
        $destino = 'gimnasiocastilloamericano@gmail.com';
        $cabeceras = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8\r\n";
        $cuerpo = "Nombre: $nombre\nEmail: $email\nTeléfono: $telefono\nAsunto: $asunto\n\nMensaje:\n$mensaje";
        if (mail($destino, "Contacto web: $asunto", $cuerpo, $cabeceras)) {
            $mensaje_enviado = true;
        } else {
            $error_envio = 'No se pudo enviar el mensaje. Intenta de nuevo más tarde.';
        }
    } else {
        $error_envio = 'Completa todos los campos obligatorios (*).';
    }
}

include "header.php";
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="contact-hero">
    <div class="container">
        <h1>Contáctanos</h1>
        <p>Estamos aquí para ayudarte. Escríbenos o visítanos.</p>
    </div>
</div>

<div class="container my-5">

    <?php if ($mensaje_enviado): ?>
        <div class="alert alert-success border-0 rounded-4 shadow-sm d-flex align-items-center gap-3 mb-4">
            <i class="bi bi-check-circle-fill fs-4"></i>
            <div>
                <strong>¡Mensaje enviado!</strong> Te responderemos a la brevedad.
            </div>
        </div>
    <?php elseif ($error_envio): ?>
        <div class="alert alert-danger border-0 rounded-4 shadow-sm d-flex align-items-center gap-3 mb-4">
            <i class="bi bi-exclamation-triangle-fill fs-4"></i>
            <div><?= htmlspecialchars($error_envio) ?></div>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- ─── COL IZQUIERDA: INFO ─── -->
        <div class="col-lg-5">

            <div class="contact-card">
                <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                <div>
                    <h6>Dirección</h6>
                    <p>Calle 3B #23-13, Barrio Callejas II<br>Valledupar – Cesar, Colombia</p>
                </div>
            </div>

            <div class="contact-card">
                <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
                <div>
                    <h6>Teléfono</h6>
                    <p><a href="tel:+573216548235" class="text-reset">321 654 8235</a></p>
                </div>
            </div>

            <div class="contact-card">
                <div class="contact-icon"><i class="bi bi-envelope-fill"></i></div>
                <div>
                    <h6>Correo Electrónico</h6>
                    <p><a href="mailto:gimnasiocastilloamericano@gmail.com" class="text-reset">gimnasiocastilloamericano@gmail.com</a></p>
                </div>
            </div>

            <div class="contact-card">
                <div class="contact-icon"><i class="bi bi-clock-fill"></i></div>
                <div>
                    <h6>Horario de Atención</h6>
                    <p>Lunes a Viernes: 7:00 a.m. – 2:00 p.m.<br>Sábados: 8:00 a.m. – 12:00 p.m.</p>
                </div>
            </div>

            <div class="contact-card">
                <div class="contact-icon"><i class="bi bi-globe2"></i></div>
                <div>
                    <h6>Síguenos</h6>
                    <div class="d-flex gap-2 mt-1">
                        <a href="#" class="social-circle" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-circle" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-circle" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        <a href="#" class="social-circle" title="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <!-- ─── COL DERECHA: FORMULARIO ─── -->
        <div class="col-lg-7">

            <div class="form-card">
                <h5><i class="bi bi-chat-dots-fill me-2" style="color:var(--gca-gold);"></i>Envíanos un mensaje</h5>
                <p class="text-muted small mb-4">Déjanos tus datos y te contactaremos lo antes posible.</p>

                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Nombre completo <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control form-contact" placeholder="Tu nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Correo electrónico <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-contact" placeholder="tu@correo.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Teléfono</label>
                            <input type="tel" name="telefono" class="form-control form-contact" placeholder="Opcional">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Asunto</label>
                            <input type="text" name="asunto" class="form-control form-contact" placeholder="¿Sobre qué nos escribes?">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium">Mensaje <span class="text-danger">*</span></label>
                            <textarea name="mensaje" class="form-control form-contact" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" name="enviar" class="btn btn-gca px-5 py-2">
                                <i class="bi bi-send-fill me-2"></i>Enviar mensaje
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <!-- ─── MAPA ─── -->
    <div class="map-card mt-4">
        <iframe
            src="https://www.google.com/maps?q=Calle+3B+23-13+Barrio+Callejas+II+Semillitas+del+reino+Valledupar&output=embed"
            width="100%"
            height="380"
            style="border:0;border-radius:16px;"
            allowfullscreen=""
            loading="lazy">
        </iframe>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Volver al inicio
        </a>
    </div>

</div>

<style>
.contact-hero {
    background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 100%);
    color: #fff;
    padding: 70px 20px 50px;
    text-align: center;
    border-bottom: 4px solid var(--gca-gold);
}
.contact-hero h1 {
    font-weight: 800;
    font-size: 2.4rem;
    margin-bottom: 8px;
}
.contact-hero h1::after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background: var(--gca-gold);
    margin: 12px auto 0;
    border-radius: 2px;
}
.contact-hero p {
    color: #bbb;
    font-size: 1.05rem;
    max-width: 500px;
    margin: 0 auto;
}

.contact-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: #fff;
    border-radius: 16px;
    padding: 20px 24px;
    margin-bottom: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    border: 1px solid #eee;
    transition: transform .2s, box-shadow .2s;
}
.contact-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(201,162,77,.12);
    border-color: var(--gca-gold);
}
.contact-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: var(--gca-gold);
    color: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.contact-card h6 {
    font-weight: 700;
    margin-bottom: 2px;
    font-size: 14px;
}
.contact-card p {
    margin: 0;
    font-size: 13px;
    color: #555;
    line-height: 1.5;
}

.social-circle {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: var(--gca-gold);
    color: #000;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    text-decoration: none;
    transition: all .2s;
}
.social-circle:hover {
    background: #b8933f;
    color: #000;
    transform: scale(1.08);
}

.form-card {
    background: #fff;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
    border: 1px solid #eee;
}
.form-card h5 {
    font-weight: 700;
    font-size: 1.2rem;
}
.form-contact {
    border-radius: 12px;
    border: 1.5px solid #e0ddd5;
    padding: 10px 14px;
    font-size: 14px;
    transition: border-color .2s, box-shadow .2s;
}
.form-contact:focus {
    border-color: var(--gca-gold);
    box-shadow: 0 0 0 3px rgba(201,162,77,.15);
}

.map-card {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
    border: 1px solid #eee;
}
</style>

<?php include "footer.php"; ?>
