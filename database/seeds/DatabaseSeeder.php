<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    protected $tables = [
        'affiliations',
        'companies',
        'company_affiliation',
        'compensation',
        'developments',
        'directors',
        'equity',
        'esg',
        'events',
        'executives',
        'financials',
        'incidents',
        'ownership',
        'persons',
        'provisions',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach( $this->tables as $table ){
            DB::statement("DELETE FROM $table;");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(Api\Companies\Models\Company::class, 50)->create()->each(function ($company) {
            // random # directors
            for( $x=rand(1,10); $x>0; $x--){
                $company->directors()->save($this->makeDirector());
            }

            // random # executives
            for( $x=rand(1,10); $x>0; $x--){
                $company->executives()->save($this->makeExecutive());
            }

            // random # events
            for( $x=rand(1,4); $x>0; $x--){
                $company->events()->save($this->makeEvent());
            }

            // random # developments
            for( $x=rand(1,8); $x>0; $x--){
                $company->developments()->save($this->makeDevelopment());
            }

            // random # provisions
            for( $x=rand(1,20); $x>0; $x--){
                $company->provisions()->save($this->makeProvision());
            }

            // random # provisions
            for( $x=rand(1,6); $x>0; $x--){
                $company->ownership()->save($this->makeOwnership());
            }

            // random # indicators
            for( $x=rand(20,50); $x>0; $x--){
                $company->indicators()->save($this->makeIndicator());
            }
        });
    }

    private function makeDirector()
    {
        $director = factory(Api\Companies\Models\Director::class)->create();

        // make person
        $person = $this->makePerson();
        $director->person()->associate($person);

        // random # of affiliations
        for( $x=rand(1,10); $x>0; $x--){
            $affiliation = $this->makeAffiliation();
            $affiliation->person()->associate($person)->save();
        }

        return $director;
    }

    private function makeExecutive()
    {
        $executive = factory(Api\Companies\Models\Executive::class)->create();
        $executive->person()->associate($this->makePerson());

        // random # compensation
        for( $x=rand(1,10); $x>0; $x--){
            $executive->compensations()->save(factory(Api\Companies\Models\Compensation::class)->make());
        }

        // random # equity
        for( $x=rand(1,10); $x>0; $x--){
            $executive->equities()->save(factory(Api\Companies\Models\Equity::class)->make());
        }

        return $executive;
    }

    private function makePerson()
    {
        return factory(Api\Companies\Models\Person::class)->create();
    }

    private function makeAffiliation()
    {
        $affiliation = factory(Api\Companies\Models\Affiliation::class)->create();

        return $affiliation;
    }

    private function makeEvent()
    {
        $event = factory(Api\Companies\Models\Event::class)->create();

        // random # incidents
        for( $x=rand(1,5); $x>0; $x--){
            $event->incidents()->save(factory(Api\Companies\Models\Incident::class)->make());
        }

        return $event;
    }

    private function makeDevelopment()
    {
        return factory(Api\Companies\Models\Development::class)->create();
    }

    private function makeProvision()
    {
        return factory(Api\Companies\Models\Provision::class)->create();
    }

    private function makeOwnership()
    {
        return factory(Api\Companies\Models\Ownership::class)->create();
    }

    private function makeIndicator()
    {
        return factory(Api\Companies\Models\Indicator::class)->create();
    }
}
