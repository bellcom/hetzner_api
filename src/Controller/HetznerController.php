<?php

namespace Drupal\hetzner_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\hetzner_api\Service\HetznerApiService;

class HetznerController extends ControllerBase {

  protected $hetznerService;

  public function __construct(HetznerApiService $hetznerService) {
    $this->hetznerService = $hetznerService;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('hetzner_api.api')
    );
  }

  /**
   * Route: /hetzner/servers
   */
  public function getServers(Request $request = NULL) {
    $force = $request && $request->query->get('refresh') === '1';
    $servers = $this->hetznerService->getServers($force);

    $header = ['Name', 'Status', 'IPv4', 'Created'];
    $rows = [];

    foreach ($servers as $server) {
      $status = ucfirst($server['status']);
      $color = $server['status'] === 'running' ? 'green' : 'red';

      $rows[] = [
        $server['name'],
        ['data' => $status, 'style' => "color:$color;font-weight:bold"],
        $server['public_net']['ipv4']['ip'] ?? '—',
        date('Y-m-d H:i', strtotime($server['created'])),
      ];
    }

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => ['id' => 'hetzner-server-table'],
      '#attached' => [
        'library' => ['hetzner_api/refresh'],
      ],
    ];
  }

  /**
   * Admin sync route: /admin/config/services/hetzner-api/sync
   */
  public function manualSync() {
    $count = $this->hetznerService->syncServersToNodes(TRUE);
    $this->messenger()->addStatus($this->t('Synkroniseret @count server(e) fra Hetzner.', ['@count' => $count]));
    return $this->redirect('system.admin_config_services');
  }

}

