<?php include "header.php"; ?>

<style>
:root {
    --gca-gold: #c9a24d;
    --gca-dark: #0f0f0f;
}

/* HERO */
.hero-servicios {
    background:
        linear-gradient(rgba(15,15,15,.7), rgba(15,15,15,.7)),
        url("assets/img/img6.png");
    background-size: cover;
    background-position: center;
    padding: 140px 20px;
    color: #fff;
}

/* TÍTULOS */
.section-title {
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.gold-line {
    width: 90px;
    height: 4px;
    background: var(--gca-gold);
    margin: 18px auto 40px;
    border-radius: 10px;
}

/* CARDS */
.course-card {
    background: #fff;
    border-radius: 22px;
    padding: 45px 30px;
    height: 100%;
    box-shadow: 0 18px 45px rgba(0,0,0,.08);
    transition: all .35s ease;
    position: relative;
}

.course-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 6px;
    background: var(--gca-gold);
    border-radius: 22px 22px 0 0;
}

.course-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 28px 65px rgba(0,0,0,.15);
}

.course-card h4 {
    font-weight: 800;
    margin-bottom: 18px;
}

.course-card p {
    color: #555;
    line-height: 1.7;
}
</style>

<!-- HERO -->
<section class="hero-servicios text-center">
    <div class="container">
        <h1 class="display-5 fw-bold">Oferta Académica</h1>
        <p class="lead mt-3">
            Formación integral desde la primera infancia hasta la educación media
        </p>
    </div>
</section>

<div class="container my-5">

    <!-- TÍTULO -->
    <div class="text-center mb-5">
        <h2 class="section-title">Niveles Educativos</h2>
        <div class="gold-line"></div>
        <p class="text-muted" style="max-width:750px;margin:auto;">
            El Gimnasio Castillo Americano ofrece un proceso educativo continuo,
            estructurado por etapas, garantizando el desarrollo académico,
            social y personal de nuestros estudiantes.
        </p>
    </div>

    <!-- CURSOS -->
    <div class="row g-4 text-center">

        <div class="col-md-4">
            <div class="course-card">
                <h4>Educación Inicial</h4>
                <p>
                    Maternal, Pre-Jardin, Jardin y Transicion.
                    Etapa fundamental para el desarrollo emocional,
                    cognitivo y social de los niños.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="course-card">
                <h4>Educación Básica Primaria</h4>
                <p>
                    Grados 1° a 5°.
                    Formación en competencias básicas,
                    valores y hábitos de estudio sólidos.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="course-card">
                <h4>Educación Básica Secundaria</h4>
                <p>
                    Grados 6° a 9°.
                    Fortalecimiento académico,
                    pensamiento crítico y responsabilidad.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="course-card">
                <h4>Educación Media</h4>
                <p>
                    Grados 10° y 11°.
                    Preparación integral para la educación superior,
                    liderazgo y proyección profesional.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="course-card">
                <h4>Formación en Valores</h4>
                <p>
                    Programa transversal enfocado en disciplina,
                    respeto, responsabilidad y convivencia,
                    presente en todos los niveles educativos.
                </p>
            </div>
        </div>

    </div>

    <!-- BOTÓN -->
    <div class="text-center mt-5">
        <a href="index.php" class="btn btn-gca px-5 py-2">
            Volver al inicio
        </a>
    </div>

</div>

<?php include "footer.php"; ?>
