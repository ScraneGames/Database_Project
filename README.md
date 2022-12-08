# Database_Project
Database project for class


## Tables that Need Insert Pages

* Allergies
* beds
* cholesterol
  * Blocked until I can figure out how to create a drop down menu populated by values from other tables
* consultations
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* contracts
* heart_risk
  * might want to just make this a view instead
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* illnesses
* inpatients
* medical_corporations
* medication_reactions
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* medications
* nurse_inpatient_assignments
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* nurses
* nurse_skills
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* nurse_surgery_assignments
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* owners
* patient_allergies
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* patient_illness
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* patient_medical_data
  * might just honestly make this a view? Currently only has blood_type and blood_sugar
    * blood_type might just fit under patient_personal data which I could just rename to patient_data since blood type is static
    * blood_sugar I could in theory put under cholesterol
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* patient_medications
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* patient_personal_data
* patient_primary
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
  * might just include this as an item in the add-patient.php once I figure out/resolve the block
* physician_owners
* physicians
* recorded_surgeries
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* salaries
* staff
* staff_patients
  * This might just be a view based on matching SSNs maybe
* surgeons
* surgery_requirements
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* surgery_schedule
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* surgery_skills
* surgery_types
* work_schedule
  * blocked until I can figure out how to create a drop down menu populated by values from other tables


## Tables Requiring View/Edit/Delete Pages

### These are all blocked until I can figure out how to display views and create a drop down menu populated by values from other tables

* Allergies
* beds
* cholesterol
* consultations
* contracts
* heart_risk
  * might want to just make this a view instead
* illnesses
* inpatients
* medical_corporations
* medication_reactions
* medications
* nurse_inpatient_assignments
* nurses
* nurse_skills
* nurse_surgery_assignments
  * blocked until I can figure out how to create a drop down menu populated by values from other tables
* owners
* patient_allergies
* patient_illness
* patient_medical_data
  * might just honestly make this a view? Currently only has blood_type and blood_sugar
    * blood_type might just fit under patient_personal data which I could just rename to patient_data since blood type is static
    * blood_sugar I could in theory put under cholesterol
* patient_medications
* patient_personal_data
* patient_primary
  * might just include this as an item in the view of patient information once I figure out/resolve the block
* physician_owners
  * might just include this in the view of physicians
* physicians
* recorded_surgeries
* salaries
  * Might just include this as a view in staff
* staff
* staff_patients
  * This might just be a view based on matching SSNs maybe, and included in both the view for patients and staff
* surgeons
* surgery_requirements
  * might just be included in the page of surgery_types
* surgery_schedule
* surgery_skills
* surgery_types
* work_schedule
  * blocked until I can figure out how to create a drop down menu populated by values from other tables

## Views I Need To Create

* heart_risk(?)
