pipeline {
    agent any

    environment {
        DOCKER_USERNAME = credentials('docker-username') // Identifiants Docker Hub
        DOCKER_PASSWORD = credentials('docker-password')
    }

    stages {
        // Étape 1 : Checkout du code
        stage('Checkout') {
            steps {
                git branch: 'BA_AMADOU_DIOULDE_burger', url: 'https://github.com/AMADOU1001/isi_burger0.git'
            }
        }

        // Étape 2 : Installer les dépendances Composer
        stage('Install Composer dependencies') {
            steps {
                sh 'composer install --prefer-dist --no-progress --no-suggest'
            }
        }

        // Étape 3 : Installer les dépendances NPM
        stage('Install NPM dependencies') {
            steps {
                sh 'npm install'
            }
        }

        // Étape 4 : Compiler les assets
        stage('Build assets') {
            steps {
                sh 'npm run build'
            }
        }

        // Étape 5 : Exécuter les tests PHPUnit
        stage('Run PHPUnit tests') {
            steps {
                sh './vendor/bin/phpunit'
            }
        }

        // Étape 6 : Créer une image Docker
        stage('Build Docker image') {
            steps {
                sh 'docker build -t isi_burger:latest .'
            }
        }

        // Étape 7 : Pousser l'image Docker (optionnel)
        stage('Push Docker image') {
            steps {
                sh '''
                echo "$DOCKER_PASSWORD" | docker login -u "$DOCKER_USERNAME" --password-stdin
                docker tag isi_burger:latest $DOCKER_USERNAME/isi_burger:latest
                docker push $DOCKER_USERNAME/isi_burger:latest
                '''
            }
        }
    }
}