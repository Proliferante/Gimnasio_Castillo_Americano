<?php include "header.php"; ?>

<style>
:root {
    --gca-gold: #c9a24d;
    --gca-dark: #0f0f0f;
    --gca-gray: #f5f6f8;
}

.section-institution {
    padding: 80px 0;
}

.section-title {
    font-weight: 900;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.section-subtitle {
    max-width: 850px;
    margin: 20px auto 0;
    font-size: 18px;
    color: #555;
}

.gold-divider {
    width: 80px;
    height: 4px;
    background: var(--gca-gold);
    margin: 20px auto;
    border-radius: 10px;
}

/* BLOQUE HISTORIA */
.history-box {
    background: linear-gradient(135deg, #ffffff, #f9f9f9);
    border-radius: 22px;
    padding: 50px;
    box-shadow: 0 18px 45px rgba(0,0,0,.08);
    margin-bottom: 80px;
}

.history-box p {
    font-size: 17px;
    line-height: 1.9;
    color: #444;
}

/* CARDS INSTITUCIONALES */
.institution-card {
    border: none;
    border-radius: 22px;
    padding: 45px 30px;
    height: 100%;
    background: #fff;
    box-shadow: 0 15px 40px rgba(0,0,0,.1);
    transition: all .35s ease;
    position: relative;
    overflow: hidden;
}

.institution-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 6px;
    background: var(--gca-gold);
}

.institution-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px rgba(0,0,0,.15);
}

.institution-card h4 {
    font-weight: 800;
    margin-bottom: 20px;
}

.institution-card p {
    color: #555;
    font-size: 16px;
    line-height: 1.7;
}

/* BLOQUE DESTACADO */
.highlight-section {
    background: linear-gradient(rgba(15,15,15,.9), rgba(15,15,15,.9)),
                url("assets/img/colegio.png");
    background-size: cover;
    background-position: center;
    border-radius: 30px;
    padding: 80px 40px;
    color: #fff;
    margin: 90px 0;
}

.highlight-section h2 {
    font-weight: 900;
}

.highlight-section p {
    max-width: 850px;
    margin: 25px auto;
    font-size: 18px;
    color: #ddd;
}

/* BOTÓN */
.btn-gca {
    background: var(--gca-gold);
    color: #000;
    border-radius: 40px;
    padding: 12px 40px;
    font-weight: 700;
    border: none;
}

.btn-gca:hover {
    background: #b8933f;
    color: #000;
}
</style>

<section class="section-institution container">

    <!-- TÍTULO -->
    <div class="text-center mb-5">
        <h1 class="section-title">Nuestra Institución</h1>
        <div class="gold-divider"></div>
        <p class="section-subtitle">
            Educación con carácter, valores sólidos y excelencia académica
        </p>
    </div>

    <!-- HISTORIA -->
    <div class="history-box text-center">
        <p>
            El <strong>Gimnasio Castillo Americano</strong> nace con la firme convicción
            de formar seres humanos íntegros, capaces de enfrentar los retos
            académicos y sociales del mundo actual, fundamentados en principios,
            disciplina y responsabilidad.
        </p>

        <p>
            Nuestra institución combina la tradición educativa con herramientas
            pedagógicas modernas, promoviendo un ambiente de aprendizaje
            estructurado, innovador y orientado al desarrollo integral de cada estudiante.
        </p>
    </div>

    <!-- MISIÓN / VISIÓN / VALORES -->
    <div class="row g-4 text-center">

        <div class="col-md-4">
            <div class="institution-card">
                <h4>Misión</h4>
                <p>
                    Formar estudiantes íntegros, responsables y críticos,
                    con una sólida preparación académica y valores éticos
                    que les permitan aportar positivamente a la sociedad.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="institution-card">
                <h4>Visión</h4>
                <p>
                    Ser reconocidos como una institución educativa de excelencia,
                    líder en innovación académica, calidad humana y compromiso social.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="institution-card">
                <h4>Valores</h4>
                <p>
                    Respeto, disciplina, responsabilidad, honestidad,
                    compromiso y trabajo en equipo como pilares
                    fundamentales de nuestra comunidad educativa.
                </p>
            </div>
        </div>

    </div>

    <!-- BLOQUE DESTACADO -->
    <div class="highlight-section text-center">
        <h2>Cultivar para Cosechar</h2>
        <p>
            En el Gimnasio Castillo Americano educamos con vocación,
            sembramos conocimiento con valores y construimos futuro
            a través de la excelencia académica.
        </p>

        <a href="index.php" class="btn btn-gca mt-4">
            Volver al inicio
        </a>
    </div>

</section>

<?php include "footer.php"; ?>
