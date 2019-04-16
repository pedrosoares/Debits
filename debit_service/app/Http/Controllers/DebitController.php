<?php

namespace App\Http\Controllers;

use App\Entities\Debit;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class DebitController extends Controller {

    /**
     * @var ClientService
     */
    private $clientService;

    public function __construct(ClientService $clientService){
        $this->clientService = $clientService;
    }

    /**
     * List all Debits
     * @return JsonResponse
     */
    public function all(){
        return Debit::get();
    }

    public function get($id){
        return Debit::findOrFail($id);
    }

    /**
     * Create a new Debit
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request){
        $validator = $this->getValidationFactory()->make($request->all(), [
            "client_id" => "required|int",
            "reason" => "required|string|min:3",
            "value" => "required|regex:/^\d+(\.\d{1,2})?$/",
            "date" => "required|date"
        ]);

        $validator->after(function(Validator $validator) {
            $client_id = $validator->getData()["client_id"];
            if (!$this->clientService->findClient($client_id)) {
                $validator->errors()->add('client_id', 'Cliente inexistente');
            }
        });

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $client_id = $request->get("client_id");
        $reason = $request->get("reason");
        $value = $request->get("value");
        $date = $request->get("date");

        $debit = Debit::create(
            compact("client_id", "reason", "value", "date")
        );

        return $debit;
    }

    /**
     * Update a Debit
     * @param Request $request
     * @return Debit
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id){
        $validator = $this->getValidationFactory()->make($request->all(), [
            "client_id" => "required|int",
            "reason" => "required|string|min:3",
            "value" => "required|regex:/^\d+(\.\d{1,2})?$/",
            "date" => "required|date"
        ]);

        $validator->after(function(Validator $validator) {
            $client_id = $validator->getData()["client_id"];
            if (!$this->clientService->findClient($client_id)) {
                $validator->errors()->add('client_id', 'Cliente inexistente');
            }
        });

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $client_id = $request->get("client_id");
        $reason = $request->get("reason");
        $value = $request->get("value");
        $date = $request->get("date");

        /** @var Debit $rule */
        $rule = Debit::findOrFail($id);

        $rule->fill(
            compact("client_id", "reason", "value", "date")
        );

        $rule->save();

        return $rule;
    }

    /**
     * Delete a Debit (Soft Delete)
     * https://laravel.com/docs/5.7/eloquent#soft-deleting
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id){

        $rule = Debit::findOrFail($id);
        $rule->delete();

        return new JsonResponse([
            "success" => "Dívida apagada com sucesso!"
        ], 200);
    }
    
}
