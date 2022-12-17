-- MySQL Script generated by MySQL Workbench
-- Sat Dec 17 03:07:53 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Project_DB
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `Project_DB` ;

-- -----------------------------------------------------
-- Schema Project_DB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Project_DB` ;
USE `Project_DB` ;

-- -----------------------------------------------------
-- Table `Project_DB`.`allergies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`allergies` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`allergies` (
  `allergy_code` INT NOT NULL AUTO_INCREMENT,
  `allergy_name` VARCHAR(45) NULL,
  `allergy_desc` VARCHAR(45) NULL,
  PRIMARY KEY (`allergy_code`),
  UNIQUE INDEX `Allergy_Code_UNIQUE` (`allergy_code` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`beds`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`beds` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`beds` (
  `bed_id` INT NOT NULL AUTO_INCREMENT,
  `nursing_unit` VARCHAR(45) NULL,
  `wing` VARCHAR(45) NULL,
  `room_number` INT NULL,
  `bed_number` VARCHAR(1) NULL,
  PRIMARY KEY (`bed_id`),
  UNIQUE INDEX `Bed_ID_UNIQUE` (`bed_id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`cholesterol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`cholesterol` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`cholesterol` (
  `fk_cholesterol_patient_id` INT NOT NULL,
  `fk_cholesterol_consultation_number` INT NOT NULL,
  `HDL` INT NULL,
  `LDL` INT NULL,
  `triglycerides` INT NULL,
  `blood_sugar` VARCHAR(45) NULL,
  PRIMARY KEY (`fk_cholesterol_patient_id`, `fk_cholesterol_consultation_number`),
  INDEX `Consultation_Number_idx` (`fk_cholesterol_consultation_number` ASC) VISIBLE,
  CONSTRAINT `Patient_Id`
    FOREIGN KEY (`fk_cholesterol_patient_id`)
    REFERENCES `Project_DB`.`consultations` (`fk_consultation_patient_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `Consultation_Number`
    FOREIGN KEY (`fk_cholesterol_consultation_number`)
    REFERENCES `Project_DB`.`consultations` (`consultation_number`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`consultations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`consultations` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`consultations` (
  `consultation_number` INT NOT NULL AUTO_INCREMENT,
  `fk_consultation_physician_id` INT NULL,
  `fk_consultation_patient_id` INT NULL,
  `date` DATE NULL,
  `time` TIME NULL,
  PRIMARY KEY (`consultation_number`),
  INDEX `Physician_ID_idx` (`fk_consultation_physician_id` ASC) VISIBLE,
  INDEX `Patient_ID_idx` (`fk_consultation_patient_id` ASC) VISIBLE,
  UNIQUE INDEX `Consultation_Number_UNIQUE` (`consultation_number` ASC) VISIBLE,
  CONSTRAINT `fk_Physician_ID`
    FOREIGN KEY (`fk_consultation_physician_id`)
    REFERENCES `Project_DB`.`physicians` (`physician_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Patient_ID`
    FOREIGN KEY (`fk_consultation_patient_id`)
    REFERENCES `Project_DB`.`patient_personal_data` (`patient_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`contracts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`contracts` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`contracts` (
  `contract_id` INT NOT NULL AUTO_INCREMENT,
  `length` INT NULL,
  `type` VARCHAR(45) NULL,
  `fk_contracts_employee_id` INT NULL,
  PRIMARY KEY (`contract_id`),
  UNIQUE INDEX `Contract_ID_UNIQUE` (`contract_id` ASC) VISIBLE,
  INDEX `surgeon_id_idx` (`fk_contracts_employee_id` ASC) VISIBLE,
  CONSTRAINT `surgeon_id`
    FOREIGN KEY (`fk_contracts_employee_id`)
    REFERENCES `Project_DB`.`staff` (`employee_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`illnesses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`illnesses` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`illnesses` (
  `illness_code` INT NOT NULL AUTO_INCREMENT,
  `illness_desc` VARCHAR(45) NULL,
  `illness_name` VARCHAR(45) NULL,
  PRIMARY KEY (`illness_code`),
  UNIQUE INDEX `Illneess_Code_UNIQUE` (`illness_code` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`inpatients`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`inpatients` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`inpatients` (
  `fk_inpatients_bed_id` INT NOT NULL,
  `fk_inpatients_patient_id` INT NOT NULL,
  `date_of_admission` DATE NULL,
  `attending_physician_id` INT NOT NULL,
  PRIMARY KEY (`fk_inpatients_bed_id`, `fk_inpatients_patient_id`, `attending_physician_id`),
  INDEX `Patient_ID_idx` (`fk_inpatients_patient_id` ASC) VISIBLE,
  INDEX `fk_attending_physician_idx` (`attending_physician_id` ASC) VISIBLE,
  CONSTRAINT `fk_inp_Patient_ID`
    FOREIGN KEY (`fk_inpatients_patient_id`)
    REFERENCES `Project_DB`.`patient_personal_data` (`patient_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_inp_Bed_ID`
    FOREIGN KEY (`fk_inpatients_bed_id`)
    REFERENCES `Project_DB`.`beds` (`bed_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_attending_physician`
    FOREIGN KEY (`attending_physician_id`)
    REFERENCES `Project_DB`.`physicians` (`physician_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`medical_corporations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`medical_corporations` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`medical_corporations` (
  `corporation_id` INT NOT NULL AUTO_INCREMENT,
  `corporation_name` VARCHAR(45) NOT NULL,
  `headquarters` VARCHAR(45) NULL,
  `fk_medical_corporations_ownership_id` INT NULL,
  PRIMARY KEY (`corporation_id`),
  UNIQUE INDEX `Corporation_Name_UNIQUE` (`corporation_name` ASC) VISIBLE,
  INDEX `Ownership_Id_idx` (`fk_medical_corporations_ownership_id` ASC) VISIBLE,
  UNIQUE INDEX `corporation_id_UNIQUE` (`corporation_id` ASC) VISIBLE,
  CONSTRAINT `fk_Ownership_Id`
    FOREIGN KEY (`fk_medical_corporations_ownership_id`)
    REFERENCES `Project_DB`.`owners` (`ownership_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`medication_reactions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`medication_reactions` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`medication_reactions` (
  `fk_initial_medication_code` INT NOT NULL,
  `fk_reacting_medication` INT NOT NULL,
  `severity` VARCHAR(45) NULL,
  PRIMARY KEY (`fk_initial_medication_code`, `fk_reacting_medication`),
  INDEX `fk_medication_code_reaction_idx` (`fk_reacting_medication` ASC) VISIBLE,
  CONSTRAINT `Medication_Code`
    FOREIGN KEY (`fk_initial_medication_code`)
    REFERENCES `Project_DB`.`medications` (`medication_code`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_medication_code_reaction`
    FOREIGN KEY (`fk_reacting_medication`)
    REFERENCES `Project_DB`.`medications` (`medication_code`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`medications`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`medications` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`medications` (
  `medication_code` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `quantity_on_hand` INT NULL,
  `quantity_on_order` INT NULL,
  `unit_cost` INT NULL,
  `ytd_usage` INT NULL,
  PRIMARY KEY (`medication_code`),
  UNIQUE INDEX `Medication_Code_UNIQUE` (`medication_code` ASC) VISIBLE,
  UNIQUE INDEX `Name_UNIQUE` (`name` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`nurse_inpatient_assignments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`nurse_inpatient_assignments` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`nurse_inpatient_assignments` (
  `fk_assignment_nurse_id` INT NULL,
  `fk_assignment_patient_id` INT NOT NULL,
  PRIMARY KEY (`fk_assignment_nurse_id`, `fk_assignment_patient_id`),
  INDEX `fk_ass_Patient_ID_idx` (`fk_assignment_patient_id` ASC) VISIBLE,
  CONSTRAINT `fk_ass_Nurse_ID`
    FOREIGN KEY (`fk_assignment_nurse_id`)
    REFERENCES `Project_DB`.`nurses` (`nurse_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ass_Patient_ID`
    FOREIGN KEY (`fk_assignment_patient_id`)
    REFERENCES `Project_DB`.`inpatients` (`fk_inpatients_patient_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`nurse_skills`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`nurse_skills` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`nurse_skills` (
  `fk_skills_nurse_id` INT NOT NULL,
  `fk_nurse_skills_skill_id` INT NOT NULL,
  PRIMARY KEY (`fk_skills_nurse_id`, `fk_nurse_skills_skill_id`),
  INDEX `Skill_Code_idx` (`fk_nurse_skills_skill_id` ASC) VISIBLE,
  CONSTRAINT `Nurse_ID`
    FOREIGN KEY (`fk_skills_nurse_id`)
    REFERENCES `Project_DB`.`nurses` (`nurse_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `Skill_Code`
    FOREIGN KEY (`fk_nurse_skills_skill_id`)
    REFERENCES `Project_DB`.`surgery_skills` (`skill_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`nurse_surgery_assignments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`nurse_surgery_assignments` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`nurse_surgery_assignments` (
  `nurse_id` INT NOT NULL,
  `surgery_code` INT NOT NULL,
  PRIMARY KEY (`nurse_id`, `surgery_code`),
  UNIQUE INDEX `nurse_id_UNIQUE` (`nurse_id` ASC) VISIBLE,
  INDEX `fk_nurse_surg_surgery_code_idx` (`surgery_code` ASC) VISIBLE,
  CONSTRAINT `fk_nurse_surg_nurse_id`
    FOREIGN KEY (`nurse_id`)
    REFERENCES `Project_DB`.`nurses` (`nurse_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_nurse_surg_surgery_code`
    FOREIGN KEY (`surgery_code`)
    REFERENCES `Project_DB`.`surgery_types` (`surgery_code`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`nurses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`nurses` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`nurses` (
  `nurse_id` INT NOT NULL AUTO_INCREMENT,
  `employee_id` INT NULL,
  `grade` VARCHAR(45) NULL,
  `experience` INT NULL,
  PRIMARY KEY (`nurse_id`),
  INDEX `Employee_Id_idx` (`employee_id` ASC) VISIBLE,
  UNIQUE INDEX `Nurse_ID_UNIQUE` (`nurse_id` ASC) VISIBLE,
  UNIQUE INDEX `Employee_ID_UNIQUE` (`employee_id` ASC) VISIBLE,
  CONSTRAINT `Employee_Id`
    FOREIGN KEY (`employee_id`)
    REFERENCES `Project_DB`.`staff` (`employee_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`owners`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`owners` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`owners` (
  `fk_owner_name` VARCHAR(45) NOT NULL,
  `shares` INT NOT NULL,
  `ownership_id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ownership_id`),
  UNIQUE INDEX `Ownership_ID_UNIQUE` (`ownership_id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`patient_allergies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`patient_allergies` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`patient_allergies` (
  `fk_allergy_patient_id` INT NOT NULL,
  `fk_allergies_allergy_code` INT NOT NULL,
  PRIMARY KEY (`fk_allergy_patient_id`, `fk_allergies_allergy_code`),
  INDEX `allergy_id_idx` (`fk_allergies_allergy_code` ASC) VISIBLE,
  CONSTRAINT `fk_all_patient_id`
    FOREIGN KEY (`fk_allergy_patient_id`)
    REFERENCES `Project_DB`.`patient_medical_data` (`fk_medical_data_patient_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_all_allergy_code`
    FOREIGN KEY (`fk_allergies_allergy_code`)
    REFERENCES `Project_DB`.`allergies` (`allergy_code`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`patient_illness`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`patient_illness` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`patient_illness` (
  `fk_illnesses_patient_id` INT NOT NULL,
  `fk_illnesses_illness_code` INT NOT NULL,
  PRIMARY KEY (`fk_illnesses_patient_id`, `fk_illnesses_illness_code`),
  INDEX `Illness_Code_idx` (`fk_illnesses_illness_code` ASC) VISIBLE,
  CONSTRAINT `fk_ill_Patient_Id`
    FOREIGN KEY (`fk_illnesses_patient_id`)
    REFERENCES `Project_DB`.`patient_medical_data` (`fk_medical_data_patient_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ill_Illness_Code`
    FOREIGN KEY (`fk_illnesses_illness_code`)
    REFERENCES `Project_DB`.`illnesses` (`illness_code`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`patient_medical_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`patient_medical_data` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`patient_medical_data` (
  `fk_medical_data_patient_id` INT NOT NULL,
  `blood_type` VARCHAR(45) NULL,
  `high_risk` TINYINT NULL,
  `primary_physician_id` INT NOT NULL,
  PRIMARY KEY (`fk_medical_data_patient_id`),
  INDEX `fk_primary_physician_id_idx` (`primary_physician_id` ASC) VISIBLE,
  CONSTRAINT `fk_medical_Patient_ID`
    FOREIGN KEY (`fk_medical_data_patient_id`)
    REFERENCES `Project_DB`.`patient_personal_data` (`patient_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_primary_physician_id`
    FOREIGN KEY (`primary_physician_id`)
    REFERENCES `Project_DB`.`physicians` (`physician_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`patient_medications`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`patient_medications` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`patient_medications` (
  `fk_medications_patient_id` INT NOT NULL,
  `fk_patient_medication_code` INT NOT NULL,
  `fk_medications_consultation_number` INT NOT NULL,
  `dosage` VARCHAR(45) NULL,
  `frequency` VARCHAR(45) NULL,
  PRIMARY KEY (`fk_medications_patient_id`, `fk_patient_medication_code`, `fk_medications_consultation_number`),
  INDEX `Medication_Code_idx` (`fk_patient_medication_code` ASC) VISIBLE,
  INDEX `Consultation_Number_idx` (`fk_medications_consultation_number` ASC) VISIBLE,
  CONSTRAINT `fk_medic_Patient_ID`
    FOREIGN KEY (`fk_medications_patient_id`)
    REFERENCES `Project_DB`.`patient_medical_data` (`fk_medical_data_patient_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_medic_Medication_Code`
    FOREIGN KEY (`fk_patient_medication_code`)
    REFERENCES `Project_DB`.`medications` (`medication_code`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_medic_Consultation_Number`
    FOREIGN KEY (`fk_medications_consultation_number`)
    REFERENCES `Project_DB`.`consultations` (`consultation_number`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`patient_personal_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`patient_personal_data` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`patient_personal_data` (
  `patient_id` INT NOT NULL AUTO_INCREMENT,
  `ssn` VARCHAR(12) NOT NULL,
  `patient_name` VARCHAR(45) NULL,
  `gender` VARCHAR(45) NULL,
  `dob` DATE NULL,
  `address` VARCHAR(45) NULL,
  `telephone_number` VARCHAR(45) NULL,
  PRIMARY KEY (`patient_id`, `ssn`),
  UNIQUE INDEX `Patient_ID_UNIQUE` (`patient_id` ASC) VISIBLE,
  UNIQUE INDEX `SSN_UNIQUE` (`ssn` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`physician_owners`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`physician_owners` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`physician_owners` (
  `fk_own_physician_id` INT NOT NULL,
  `fk_own_employee_name` VARCHAR(45) NOT NULL,
  `fk_physician_own_ownership_id` INT NOT NULL,
  PRIMARY KEY (`fk_own_physician_id`, `fk_own_employee_name`, `fk_physician_own_ownership_id`),
  INDEX `Ownership_ID_idx` (`fk_physician_own_ownership_id` ASC) VISIBLE,
  INDEX `Employee_Name_idx` (`fk_own_employee_name` ASC) VISIBLE,
  CONSTRAINT `Physician_ID_fk`
    FOREIGN KEY (`fk_own_physician_id`)
    REFERENCES `Project_DB`.`physicians` (`physician_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `Employee_Name_fk`
    FOREIGN KEY (`fk_own_employee_name`)
    REFERENCES `Project_DB`.`physicians` (`employee_name`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `Ownership_ID_fk`
    FOREIGN KEY (`fk_physician_own_ownership_id`)
    REFERENCES `Project_DB`.`owners` (`ownership_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`physicians`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`physicians` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`physicians` (
  `physician_id` INT NOT NULL AUTO_INCREMENT,
  `employee_id` INT NOT NULL,
  `position` VARCHAR(45) NOT NULL,
  `specialty` VARCHAR(45) NULL,
  `employee_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`physician_id`, `employee_id`, `position`),
  INDEX `Position_idx` (`position` ASC) VISIBLE,
  INDEX `Employee_Name_idx` (`employee_name` ASC) VISIBLE,
  UNIQUE INDEX `Physician_ID_UNIQUE` (`physician_id` ASC) VISIBLE,
  UNIQUE INDEX `Employee_ID_UNIQUE` (`employee_id` ASC) VISIBLE,
  CONSTRAINT `fk_physician_Employee_ID`
    FOREIGN KEY (`employee_id`)
    REFERENCES `Project_DB`.`staff` (`employee_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_physician_Position`
    FOREIGN KEY (`position`)
    REFERENCES `Project_DB`.`staff` (`position`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_physician_Employee_Name`
    FOREIGN KEY (`employee_name`)
    REFERENCES `Project_DB`.`staff` (`employee_name`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`salaries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`salaries` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`salaries` (
  `fk_salary_position` VARCHAR(45) NOT NULL,
  `salary` INT NULL,
  `fk_salary_employee_id` INT NULL,
  PRIMARY KEY (`fk_salary_employee_id`, `fk_salary_position`),
  INDEX `Employee_ID_idx` (`fk_salary_employee_id` ASC) VISIBLE,
  UNIQUE INDEX `EmployeeID_UNIQUE` (`fk_salary_employee_id` ASC) VISIBLE,
  CONSTRAINT `fk_sal_Employee_ID`
    FOREIGN KEY (`fk_salary_employee_id`)
    REFERENCES `Project_DB`.`staff` (`employee_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_sal_Position`
    FOREIGN KEY (`fk_salary_position`)
    REFERENCES `Project_DB`.`staff` (`position`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`staff`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`staff` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`staff` (
  `ssn` CHAR(12) NOT NULL,
  `employee_id` INT NOT NULL AUTO_INCREMENT,
  `employee_name` VARCHAR(45) NOT NULL,
  `gender` VARCHAR(45) NOT NULL,
  `address` VARCHAR(45) NOT NULL,
  `telephone_number` VARCHAR(45) NOT NULL,
  `position` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`ssn`, `employee_id`),
  UNIQUE INDEX `SSN_UNIQUE` (`ssn` ASC) VISIBLE,
  UNIQUE INDEX `EmployeeID_UNIQUE` (`employee_id` ASC) VISIBLE,
  INDEX `Employee_Name` (`employee_name` ASC) VISIBLE,
  INDEX `Position` (`position` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`surgeons`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`surgeons` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`surgeons` (
  `surgeon_id` INT NOT NULL AUTO_INCREMENT,
  `employee_id` INT NULL,
  `contract_id` INT NULL,
  `specialty` VARCHAR(45) NULL,
  PRIMARY KEY (`surgeon_id`),
  INDEX `Employee_ID_idx` (`employee_id` ASC) VISIBLE,
  INDEX `Contract_ID_idx` (`contract_id` ASC) VISIBLE,
  UNIQUE INDEX `Contract_ID_UNIQUE` (`contract_id` ASC) VISIBLE,
  UNIQUE INDEX `Employee_Id_UNIQUE` (`employee_id` ASC) VISIBLE,
  UNIQUE INDEX `Surgeon_ID_UNIQUE` (`surgeon_id` ASC) VISIBLE,
  CONSTRAINT `fk_sur_Employee_ID`
    FOREIGN KEY (`employee_id`)
    REFERENCES `Project_DB`.`staff` (`employee_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_sur_Contract_ID`
    FOREIGN KEY (`contract_id`)
    REFERENCES `Project_DB`.`contracts` (`contract_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`surgery_requirements`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`surgery_requirements` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`surgery_requirements` (
  `fk_requirement_surgery_code` INT NOT NULL,
  `fk_requirement_skill_id` INT NOT NULL,
  PRIMARY KEY (`fk_requirement_surgery_code`, `fk_requirement_skill_id`),
  INDEX `Skill_ID_idx` (`fk_requirement_skill_id` ASC) VISIBLE,
  CONSTRAINT `fk_req_Surgery_Code`
    FOREIGN KEY (`fk_requirement_surgery_code`)
    REFERENCES `Project_DB`.`surgery_types` (`surgery_code`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_req_Skill_ID`
    FOREIGN KEY (`fk_requirement_skill_id`)
    REFERENCES `Project_DB`.`surgery_skills` (`skill_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`surgery_schedule`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`surgery_schedule` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`surgery_schedule` (
  `operating_theater` INT NOT NULL,
  `date` DATE NULL,
  `fk_schedule_surgery_code` INT NOT NULL,
  `fk_nurse_id` INT NOT NULL,
  `time` TIME NULL,
  `fk_schedule_surgeon_id` INT NOT NULL,
  `patient_id` INT NULL,
  `surgery_id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`surgery_id`),
  INDEX `Surgery_code_idx` (`fk_schedule_surgery_code` ASC) VISIBLE,
  INDEX `Nurse1_idx` (`fk_nurse_id` ASC) VISIBLE,
  INDEX `Surgeon_idx` (`fk_schedule_surgeon_id` ASC) VISIBLE,
  INDEX `fk_surg_sched_patient_id_idx` (`patient_id` ASC) VISIBLE,
  CONSTRAINT `fk_surg_sched_Surgery_code`
    FOREIGN KEY (`fk_schedule_surgery_code`)
    REFERENCES `Project_DB`.`surgery_types` (`surgery_code`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_surg_sched_Nurse1`
    FOREIGN KEY (`fk_nurse_id`)
    REFERENCES `Project_DB`.`nurses` (`nurse_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_surg_sched_Surgeon`
    FOREIGN KEY (`fk_schedule_surgeon_id`)
    REFERENCES `Project_DB`.`surgeons` (`surgeon_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_surg_sched_patient_id`
    FOREIGN KEY (`patient_id`)
    REFERENCES `Project_DB`.`patient_personal_data` (`patient_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`surgery_skills`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`surgery_skills` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`surgery_skills` (
  `skill_id` INT NOT NULL AUTO_INCREMENT,
  `skill_desc` VARCHAR(45) NULL,
  `skill_name` VARCHAR(45) NULL,
  PRIMARY KEY (`skill_id`),
  UNIQUE INDEX `Skill_ID_UNIQUE` (`skill_id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`surgery_types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`surgery_types` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`surgery_types` (
  `surgery_code` INT NOT NULL AUTO_INCREMENT,
  `type_desc` VARCHAR(45) NULL,
  `anatomical_location` VARCHAR(45) NULL,
  `special_needs` VARCHAR(45) NULL,
  `category` VARCHAR(45) NULL,
  `type_name` VARCHAR(45) NULL,
  PRIMARY KEY (`surgery_code`),
  UNIQUE INDEX `Surgery_Code_UNIQUE` (`surgery_code` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Project_DB`.`work_schedule`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Project_DB`.`work_schedule` ;

CREATE TABLE IF NOT EXISTS `Project_DB`.`work_schedule` (
  `fk_work_schedule_employee_id` INT NOT NULL,
  `monday` TINYINT NULL,
  `start_time` TIME NULL,
  `tuesday` TINYINT NULL,
  `wednesday` TINYINT NULL,
  `thursday` TINYINT NULL,
  `friday` TINYINT NULL,
  `saturday` TINYINT NULL,
  `sunday` TINYINT NULL,
  `end_time` TIME NULL,
  PRIMARY KEY (`fk_work_schedule_employee_id`),
  CONSTRAINT `fk_shed_work_employee_ID`
    FOREIGN KEY (`fk_work_schedule_employee_id`)
    REFERENCES `Project_DB`.`staff` (`employee_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

USE `Project_DB` ;

-- -----------------------------------------------------
-- View `Project_DB`.`heart_risk_view`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`heart_risk_view` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW heart_risk_view (patient_id, patient_name, consultation_id, physician_name, date, blood_sugar, hdl, ldl, triglycerides, total_cholesterol, heart_risk) AS 
SELECT patient_personal_data.patient_id, patient_personal_data.patient_name, cholesterol.fk_cholesterol_consultation_number, physicians.employee_name, consultations.date, blood_sugar, hdl, ldl,triglycerides, (hdl+ldl+(.2*triglycerides)), 
		(CASE
		WHEN ((hdl+ldl+(.2*triglycerides))/hdl) <4 THEN 'None'
        WHEN (4<=(hdl+ldl+(.2*triglycerides))/hdl)<5 THEN 'Low'
        WHEN ((hdl+ldl+(.2*triglycerides))/hdl)>=5 THEN 'Moderate'
        END)
FROM cholesterol, patient_personal_data, patient_medical_data, consultations, physicians
WHERE cholesterol.fk_cholesterol_patient_id = patient_personal_data.patient_id 
AND patient_personal_data.patient_id = patient_medical_data.fk_medical_data_patient_id 
AND patient_personal_data.patient_id = consultations.fk_consultation_patient_id
AND cholesterol.fk_cholesterol_consultation_number = consultations.consultation_number
AND consultations.fk_consultation_physician_id = physicians.physician_id;

-- -----------------------------------------------------
-- View `Project_DB`.`staff_as_patients`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`staff_as_patients` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW staff_as_patients (name, ssn, employee_id, patient_id, position) AS
SELECT staff.employee_name, staff.ssn, staff.employee_id, patient_personal_data.patient_id, staff.position
FROM staff, patient_personal_data
WHERE staff.ssn = patient_personal_data.ssn;

-- -----------------------------------------------------
-- View `Project_DB`.`ownership_perc`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`ownership_perc` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW ownership_perc (name, shares, perc) AS
SELECT fk_owner_name, shares, shares * 100 / (SELECT SUM(shares) AS s FROM owners)
FROM owners;

-- -----------------------------------------------------
-- View `Project_DB`.`view_patient_illnesses`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`view_patient_illnesses` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW view_patient_illnesses (patient_name, patient_id, illness_name, illness_desc) AS
SELECT patient_personal_data.patient_name, patient_personal_data.patient_id, illnesses.illness_name, illnesses.illness_desc
FROM patient_personal_data
JOIN patient_illness
ON patient_personal_data.patient_id = fk_illnesses_patient_id
JOIN illnesses
ON patient_illness.fk_illnesses_illness_code = illnesses.illness_code;


-- -----------------------------------------------------
-- View `Project_DB`.`surgeries_by_surgeons`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`surgeries_by_surgeons` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW surgeries_by_surgeons (surgeon, surgeon_id, surgery_id) AS
SELECT staff.employee_name, surgery_schedule.fk_schedule_surgeon_id, surgery_schedule.surgery_id  
FROM staff 
JOIN surgeons 
ON staff.employee_id = surgeons.employee_id 
JOIN surgery_schedule 
ON surgeons.surgeon_id = surgery_schedule.fk_schedule_surgeon_id;

-- -----------------------------------------------------
-- View `Project_DB`.`surgeries_by_nurse`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`surgeries_by_nurse` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW surgeries_by_nurse (nurse, nurse_id, surgery_id) AS
SELECT staff.employee_name, surgery_schedule.fk_nurse_id, surgery_schedule.surgery_id 
FROM staff 
JOIN nurses 
ON staff.employee_id = nurses.employee_id 
JOIN surgery_schedule 
ON nurses.nurse_id = surgery_schedule.fk_nurse_id;

-- -----------------------------------------------------
-- View `Project_DB`.`surgeries_by_patient`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`surgeries_by_patient` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW surgeries_by_patient (patient_name, patient_id, surgery_id) AS
SELECT patient_name, surgery_schedule.patient_id, surgery_schedule.surgery_id
FROM patient_personal_data
JOIN surgery_schedule
ON patient_personal_data.patient_id = surgery_schedule.patient_id;

-- -----------------------------------------------------
-- View `Project_DB`.`view_surgeries`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`view_surgeries` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW view_surgeries (surgery_id, operating_theater, date, time, surgery_type, category, 
surgeon, surgeon_id, nurse, nurse_id, patient_name, patient_id) AS
SELECT surgery_schedule.surgery_id, surgery_schedule.operating_theater, surgery_schedule.date, 
surgery_schedule.time, surgery_types.type_name, surgery_types.category, surgeries_by_surgeons.surgeon, surgeries_by_surgeons.surgeon_id, 
surgeries_by_nurse.nurse, surgeries_by_nurse.nurse_id, surgeries_by_patient.patient_name, surgery_schedule.patient_id
FROM surgery_schedule
JOIN surgeries_by_surgeons
ON surgery_schedule.surgery_id = surgeries_by_surgeons.surgery_id
JOIN surgeries_by_nurse
ON surgery_schedule.surgery_id = surgeries_by_nurse.surgery_id
JOIN surgeries_by_patient
ON surgery_schedule.surgery_id = surgeries_by_patient.surgery_id
JOIN surgery_types
ON surgery_schedule.fk_schedule_surgery_code = surgery_types.surgery_code;


-- -----------------------------------------------------
-- View `Project_DB`.`view_patient_allergies`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`view_patient_allergies` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW `view_patient_allergies` (patient_name, patient_id, allergy_name, allergy_desc) AS
SELECT patient_personal_data.patient_name, patient_personal_data.patient_id, allergies.allergy_name, allergies.allergy_desc
FROM patient_personal_data
JOIN patient_allergies
ON patient_personal_data.patient_id = patient_allergies.fk_allergy_patient_id
JOIN allergies
ON patient_allergies.fk_allergies_allergy_code = allergies.allergy_code;

-- -----------------------------------------------------
-- View `Project_DB`.`view_consultations`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`view_consultations` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW view_consultations (consultation_number, physician_id, physician, patient, patient_id, date, time) AS
SELECT consultation_number, fk_consultation_physician_id, staff.employee_name, patient_personal_data.patient_name, fk_consultation_patient_id, date, time
FROM consultations
JOIN physicians
ON consultations.fk_consultation_physician_id = physicians.physician_id
JOIN staff
ON physicians.employee_id = staff.employee_id
JOIN patient_personal_data
ON consultations.fk_consultation_patient_id = patient_personal_data.patient_id;

-- -----------------------------------------------------
-- View `Project_DB`.`first_reacting_medication`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`first_reacting_medication` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW first_reacting_medication (medication_id, medication_name) AS
SELECT fk_initial_medication_code, name
FROM medication_reactions
JOIN medications
ON fk_initial_medication_code = medication_code;

-- -----------------------------------------------------
-- View `Project_DB`.`second_reacting_medication`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`second_reacting_medication` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW second_reacting_medication (reacting_medication_id, medication_name, first_medication_id, severity) AS
SELECT fk_reacting_medication, name, fk_initial_medication_code, severity
FROM medication_reactions
JOIN medications
ON fk_reacting_medication = medication_code;

-- -----------------------------------------------------
-- View `Project_DB`.`view_medication_reactions`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `Project_DB`.`view_medication_reactions` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW view_medication_reactions (medication_id, medication_name, reacting_id, reacting_name, 
severity) AS
SELECT medication_id, first_reacting_medication.medication_name, reacting_medication_id, 
second_reacting_medication.medication_name, severity
FROM first_reacting_medication
JOIN second_reacting_medication
ON first_reacting_medication.medication_id = second_reacting_medication.first_medication_id;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
