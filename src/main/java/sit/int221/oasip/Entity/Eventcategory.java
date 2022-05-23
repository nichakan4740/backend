package sit.int221.oasip.Entity;

import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.Getter;
import lombok.Setter;
import org.hibernate.validator.constraints.Range;

import javax.persistence.*;
import javax.validation.constraints.*;
import java.time.LocalTime;
import java.util.LinkedHashSet;
import java.util.List;
import java.util.Set;

@Getter
@Setter
@Entity
@Table(name = "eventcategory")
public class Eventcategory {
    @Id
    @Column(name = "eventCategoryID", nullable = false)
    private Integer id;

    @NotEmpty
    @UniqueElements
    @Size(min = 1 , max = 100 , message = "CategoryName is not empty and must between 0 - 100")
    @Column(name = "eventCategoryName", nullable = false, length = 100)
    private String eventCategoryName;

    @Size(max = 500 , message = "CategoryDescription must between 0 - 500")
    @Column(name = "eventCategoryDescription", length = 500)
    private String eventCategoryDescription;

    @NotNull(message = "Duration is not null and must between 1 - 480")
    @Min(1)
    @Max(480)
    @Column(name = "eventDuration", nullable = false)
    private Integer eventDuration;

    @JsonIgnore
    @OneToMany(mappedBy = "eventCategoryID")
    private Set<Event> event ;

}