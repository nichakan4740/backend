package sit.int221.oasip.Repository;

import org.springframework.data.jpa.repository.JpaRepository;
import sit.int221.oasip.Entity.Events;

public interface EventsRepository extends JpaRepository<Events, Integer> {

}
