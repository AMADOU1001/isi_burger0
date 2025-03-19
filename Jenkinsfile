pipeline {
    agent any

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
                bat 'composer install --prefer-dist --no-progress --no-suggest'
            }
        }

        // Étape 3 : Installer les dépendances NPM
        stage('Install NPM dependencies') {
            steps {
                bat 'npm install'
            }
        }

        // Étape 4 : Compiler les assets
        stage('Build assets') {
            steps {
                bat 'npm run build'
            }
        }

        

        // Étape 5 : Créer une image Docker
        stage('Build Docker image') {
            steps {
                bat 'docker build -t isi_burger:latest .'
            }
        }
    }
}