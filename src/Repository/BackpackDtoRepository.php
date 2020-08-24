<?php


namespace App\Repository;


use DateTime;
use App\Dto\RubricDto;
use App\Dto\ProcessDto;
use App\Dto\BackpackDto;
use App\Dto\MProcessDto;
use App\Entity\Backpack;
use App\Entity\MProcess;
use App\Dto\DtoInterface;
use App\Entity\BackpackLink;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class BackpackDtoRepository extends ServiceEntityRepository implements DtoRepositoryInterface
{
    use TraitDtoRepository;

    /**
     * @var BackpackDto
     */
    private $dto;

    const ALIAS = 'b';

    const FILTRE_DTO_INIT_HOME = 'home';
    const FILTRE_DTO_INIT_TREE = 'tree';
    const FILTRE_DTO_INIT_SEARCH = 'search';
    const FILTRE_DTO_INIT_UNITAIRE = 'unitaire';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Backpack::class);
    }

    public function countForDto(DtoInterface $dto)
    {
        /**
         * var ContactDto
         */
        $this->dto = $dto;

        $this->initialise_selectCount();

        $this->initialise_where();

        $this->initialise_orderBy();



        return $this->builder
            ->getQuery()->getSingleScalarResult();
    }

    public function findAllForDtoPaginator(DtoInterface $dto, $page = null, $limit = null)
    {
        /**
         * var ContactDto
         */
        $this->dto = $dto;

        $this->initialise_select();

        $this->initialise_where();

        $this->initialise_orderBy();

        if (empty($page)) {
            $this->builder
                ->getQuery()
                ->getResult();
        } else {
            $this->builder
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit);
        }

        return new Paginator($this->builder);
    }

    public function findAllForDto(DtoInterface $dto, string $filtre = self::FILTRE_DTO_INIT_HOME)
    {
        /**
         * var ContactDto
         */
        $this->dto = $dto;

        switch ($filtre) {
            case self::FILTRE_DTO_INIT_TREE:
                $this->initialise_select_tree();
                break;
            case self::FILTRE_DTO_INIT_UNITAIRE:
                $this->initialise_select();
                break;
            case self::FILTRE_DTO_INIT_HOME:
                $this->initialise_select_home();
                break;
            case self::FILTRE_DTO_INIT_SEARCH:
                $this->initialise_select();
                break;
        }

        $this->initialise_where();

        $this->initialise_orderBy();

        return $this->builder
            ->getQuery()
            ->getResult();
    }

    private function initialise_select_home()
    {
        $this->builder = $this->createQueryBuilder(self::ALIAS)
            ->select(
                self::ALIAS,
                CategoryRepository::ALIAS,
                MProcessRepository::ALIAS,
                ProcessRepository::ALIAS
            )
            ->join(self::ALIAS . '.category', CategoryRepository::ALIAS)
            ->join(self::ALIAS . '.mProcess', MProcessRepository::ALIAS)
            ->leftjoin(self::ALIAS . '.process', ProcessRepository::ALIAS);
    }

    private function initialise_select_tree()
    {
        $this->builder = $this->createQueryBuilder(self::ALIAS)
            ->select(
                self::ALIAS,
                CategoryRepository::ALIAS,
                MProcessRepository::ALIAS,
                ProcessRepository::ALIAS,
                BackpackFileRepository::ALIAS,
                BackpackLinkRepository::ALIAS
            )
            ->join(self::ALIAS . '.category', CategoryRepository::ALIAS)
            ->join(self::ALIAS . '.mProcess', MProcessRepository::ALIAS)
            ->leftjoin(self::ALIAS . '.process', ProcessRepository::ALIAS)
            ->leftJoin(self::ALIAS . '.backpackFiles', BackpackFileRepository::ALIAS)
            ->leftJoin(self::ALIAS . '.backpackLinks', BackpackLinkRepository::ALIAS);
    }

    private function initialise_select()
    {
        $this->builder = $this->createQueryBuilder(self::ALIAS)
            ->select(
                self::ALIAS,
                CategoryRepository::ALIAS,
                MProcessRepository::ALIAS,
                ProcessRepository::ALIAS
            )
            ->join(self::ALIAS . '.category', CategoryRepository::ALIAS)
            ->join(self::ALIAS . '.mProcess', MProcessRepository::ALIAS)
            ->leftjoin(self::ALIAS . '.process', ProcessRepository::ALIAS)
            ->leftjoin(self::ALIAS . '.process', ProcessRepository::ALIAS);
    }

    private function initialise_selectCount()
    {
        $this->builder = $this->createQueryBuilder(self::ALIAS)
            ->select('count(distinct ' . self::ALIAS . '.id)')
            ->join(self::ALIAS . '.mProcess', MProcessRepository::ALIAS)
            ->leftjoin(self::ALIAS . '.process', ProcessRepository::ALIAS);
    }

    private function initialise_where()
    {
        $this->params = [];
        $dto = $this->dto;

        $this->builder
            ->where(self::ALIAS . '.id>0');


        $this->initialise_where_mprocess();

        $this->initialise_where_process();

        $this->initialise_where_owner();

        $this->initialise_where_new();

        $this->initialise_where_enable();

        $this->initialise_where_state();

        $this->initialise_where_search();

        if (count($this->params) > 0) {
            $this->builder->setParameters($this->params);
        }
    }


    private function initialise_where_new()
    {
        if ($this->dto->getIsNew() == BackpackDto::TRUE) {
            $to = date('Y-m-d', strtotime((new DateTime())->format('Y-m-d') . ' +1 day'));
            $from = date('Y-m-d', strtotime((new DateTime())->format('Y-m-d') . ' -8 day'));

            $this->builder->andWhere(
                self::ALIAS . '.updateAt BETWEEN  :from AND :to'
            );

            $this->addParams('from', $from);
            $this->addParams('to', $to);
        }
    }

    private function initialise_where_state()
    {

        if (!empty($this->dto->getCurrentState())) {
            $this->builder->andwhere(self::ALIAS . '.currentState = :state');
            $this->addParams('state', $this->dto->getCurrentState());
        }
    }

    private function initialise_where_enable()
    {

        if (!empty($this->dto->getVisible())) {
            $this->builder->andwhere(MProcessRepository::ALIAS . '.isEnable= true');
            $this->builder->andWhere('(' . ProcessRepository::ALIAS . '.isEnable= true or ' . ProcessRepository::ALIAS . ' . isEnable is null)');
        } else if (!empty($this->dto->getHide())) {
            $this->builder->andWhere(
                MProcessRepository::ALIAS . '.isEnable= false OR ' .
                    ProcessRepository::ALIAS . '.isEnable= false '
            );
        } else {
            $e = $this->dto->getMProcessDto();
            if (!empty($e)) {
                if ($e->getIsEnable() == MProcessDto::TRUE) {
                    $this->builder->andwhere(MProcessRepository::ALIAS . '.isEnable= true');
                } elseif ($e == MProcessDto::FALSE) {
                    $this->builder->andwhere(MProcessRepository::ALIAS . '.isEnable= false');
                }
            }

            $e = $this->dto->getProcessDto();
            if (!empty($e)) {
                if ($e->getIsEnable() == ProcessDto::TRUE) {
                    $this->builder->andWhere(ProcessRepository::ALIAS . '.isEnable= true');
                } elseif ($e->getIsEnable() == ProcessDto::FALSE) {
                    $this->builder->andWhere(ProcessRepository::ALIAS . '.isEnable= false');
                }
            }
        }
    }

    private function initialise_where_mprocess()
    {
        $r = $this->dto->getMProcessDto();
        if (!empty($r) && !empty($r->getId())) {
            $this->builder->andwhere(MProcessRepository::ALIAS . '.id = :mprocessid');
            $this->addParams('mprocessid', $r->getId());
        }
    }

    private function initialise_where_process()
    {
        $r = $this->dto->getProcessDto();
        if (!empty($r) && !empty($r->getId())) {
            $this->builder->andwhere(ProcessRepository::ALIAS . '.id = :processid');
            $this->addParams('processid', $r->getId());
        }
    }

    private function initialise_where_owner()
    {
        $r = $this->dto->getOwnerDto();
        if (!empty($r) && !empty($r->getId())) {
            $this->builder->andwhere(self::ALIAS . '.owner = :ownerid');
            $this->addParams('ownerid', $r->getId());
        }
    }

    private function initialise_where_search()
    {
        $dto = $this->dto;
        $builder = $this->builder;
        if (!empty($dto->getWordSearch())) {
            $builder
                ->andwhere(
                    self::ALIAS . '.content like :search' .
                        ' OR ' . self::ALIAS . '.dir1 like :search' .
                        ' OR ' . self::ALIAS . '.dir2 like :search' .
                        ' OR ' . self::ALIAS . '.dir3 like :search' .
                        ' OR ' . self::ALIAS . '.dir4 like :search' .
                        ' OR ' . self::ALIAS . '.dir5 like :search' .
                        ' OR ' . self::ALIAS . '.name like :search' .
                        ' OR ' . self::ALIAS . '.contentState like :search' .
                        ' OR ' . BackpackLinkRepository::ALIAS . '.title like :search' .
                        ' OR ' . BackpackLinkRepository::ALIAS . '.link like :search' .
                        ' OR ' . BackpackLinkRepository::ALIAS . '.content like :search' .
                        ' OR ' . BackpackFileRepository::ALIAS . '.title like :search' .
                        ' OR ' . BackpackFileRepository::ALIAS . '.fileName like :search' .
                        ' OR ' . BackpackFileRepository::ALIAS . '.content like :search'
                );

            $this->addParams('search', '%' . $dto->getWordSearch() . '%');
        }
    }

    private function initialise_orderBy()
    {
        $this->builder
            ->addOrderBy(MProcessRepository::ALIAS . '.ref', 'ASC')
            ->addOrderBy(MProcessRepository::ALIAS . '.name', 'ASC')
            ->addOrderBy(processRepository::ALIAS . '.ref', 'ASC')
            ->addOrderBy(processRepository::ALIAS . '.name', 'ASC')
            ->addOrderBy(self::ALIAS . '.dir1', 'ASC')
            ->addOrderBy(self::ALIAS . '.dir2', 'ASC')
            ->addOrderBy(self::ALIAS . '.dir3', 'ASC')
            ->addOrderBy(self::ALIAS . '.dir4', 'ASC')
            ->addOrderBy(self::ALIAS . '.dir5', 'ASC')
            ->addOrderBy(self::ALIAS . '.name', 'ASC');
    }
}