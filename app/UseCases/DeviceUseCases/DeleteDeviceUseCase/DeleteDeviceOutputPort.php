<?php

namespace App\UseCases\DeviceUseCases\DeleteDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteDeviceOutputPort
{
    /**
     * @param  DeleteDeviceResponseModel  $response
     * @return ViewModel
     */
    public function deviceDeleted(DeleteDeviceResponseModel $response): ViewModel;

    /**
     * @param  DeleteDeviceResponseModel  $response
     * @return ViewModel
     */
    public function noSuchDevice(DeleteDeviceResponseModel $response): ViewModel;

    /**
     * @param  DeleteDeviceResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function deletionFailed(DeleteDeviceResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  DeleteDeviceResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToDeleteDevice(DeleteDeviceResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  DeleteDeviceResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(DeleteDeviceResponseModel $response): ViewModel;
}
